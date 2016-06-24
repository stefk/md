<?php

namespace MD\Testing;

use MD\Analyser;
use MD\Levels;
use MD\Reporter;
use MD\Ruleset;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

abstract class RuleTestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getRule();

    /**
     * @dataProvider sampleProvider
     */
    public function testSamples($file, array $expectedViolations)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $set = new Ruleset();
        $set->addRule($this->getRule());
        $analyser = new Analyser($parser, new NodeTraverser(), $set, new Reporter());
        $analyser->analyseFile($file);
        $violations = $analyser->getReporter()->getViolations();

        $count = count($violations);
        $expectedCount = count($expectedViolations);

        // @codeCoverageIgnoreStart
        if ($count === 0 && $expectedCount > 0) {
            $this->fail("{$expectedCount} violations were expected in {$file}, none found");
        }
        // @codeCoverageIgnoreEnd

        $stdViolations = array_map(function ($violation) {
            return $violation->toStdClass();
        }, $violations);

        $this->assertEquals(
            $expectedViolations,
            $stdViolations,
            "\nExpected:\n".json_encode($expectedViolations, JSON_PRETTY_PRINT).
            "\nActual:\n".json_encode($stdViolations, JSON_PRETTY_PRINT)
        );
    }

    /**
     * @codeCoverageIgnore (data providers are executed before tests start)
     */
    public function sampleProvider()
    {
        $ruleName = $this->getRule()->name();
        $dataDir = realpath(__DIR__.'/../../tests/Data/Rule');
        $dataSets = [];

        foreach (new \DirectoryIterator($dataDir) as $item) {
            if (!$item->isFile() || $item->getExtension() !== 'php') {
                continue;
            }

            $baseName = $item->getBaseName('.php');

            if (0 === strpos($baseName, $ruleName)) {
                $jsonFile = "{$dataDir}/{$baseName}.json";

                if (!file_exists($jsonFile)) {
                    throw new \Exception("No associated json file found for {$item->getPathname()}");
                }

                $violations = json_decode(file_get_contents($jsonFile));

                if (JSON_ERROR_NONE !== json_last_error()) {
                    throw new \Error("Cannot decode json file '{$jsonFile}': ".json_last_error_msg());
                }

                $dataSets[] = [$item->getPathname(), $violations];
            }

        }

        if (count($dataSets) === 0) {
            throw new \Exception("No test samples found for rule '{$ruleName}'");
        }

        return $dataSets;
    }
}
