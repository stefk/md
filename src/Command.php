<?php

namespace MD;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('md:analyse')
            ->setDescription('Analyse files/directories')
            ->addArgument(
                'files',
                InputArgument::OPTIONAL|InputArgument::IS_ARRAY,
                'Target files/directories',
                [getcwd()]
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $targets = $input->getArgument('files');

        foreach ($targets as $target) {
            if (!file_exists($target)) {
                throw new \Exception("'{$target}' is not a valid path");
            }
        }

        $analyser = Analyser::buildDefault();

        foreach ($targets as $target) {
            if (is_file($target)) {
                if (pathinfo($target, PATHINFO_EXTENSION) === 'php') {
                    $analyser->analyseFile($target);
                }
            } else {
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($target, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST,
                    \RecursiveIteratorIterator::CATCH_GET_CHILD
                );

                foreach ($iterator as $path => $target) {
                    if ($target->isFile() && $target->getExtension() === 'php') {
                        $analyser->analyseFile($path);
                    }
                }
            }
        }

        $violations = $analyser->getReporter()->getViolations();

        foreach ($violations as $violation) {
            $output->writeln((string) $violation);
        }

        return count($violations) === 0 ? 0 : 1;
    }
}
