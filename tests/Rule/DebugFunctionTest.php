<?php

namespace MD\Rule;

use MD\Analyser;
use MD\Reporter;
use MD\Ruleset;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

class DebugFunctionTest extends \PHPUnit_Framework_TestCase
{
    private $analyser;

    protected function setUp()
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $set = new Ruleset();
        $set->addRule(new \MD\Rule\DebugFunction());
        $this->analyser = new Analyser($parser, new NodeTraverser(), $set, new Reporter());
    }

    /**
     * @dataProvider ruleDataProvider
     */
    public function test($source, array $expectedViolations)
    {
        $this->analyser->analyse($source);
        $violations = $this->analyser->getReporter()->getViolations();

        $this->assertEquals(
            $expectedCount = count($expectedViolations),
            $expectedCount > 0 ? count($violations['']) : 0
        );

        foreach ($expectedViolations as $i => $violation) {
            $this->assertEquals($violation->message, $violations[''][$i][0]);
        }
    }

    public function ruleDataProvider()
    {
        $dataDir = realpath(__DIR__.'/../Data/Rule');
        $dataSets = [];

        foreach (new \DirectoryIterator($dataDir) as $item) {
            if ($item->isFile() && $item->getExtension() === 'php') {
                $jsonFile = sprintf('%s/%s.json', $dataDir, $item->getBaseName('.php'));

                if (!file_exists($jsonFile)) {
                    throw new \Exception("No associated json file found for {$item->getPathname()}");
                }

                $dataSets[] = [
                    file_get_contents($item->getPathname()),
                    json_decode(file_get_contents($jsonFile))
                ];
            }

        }

        return $dataSets;
    }
}
