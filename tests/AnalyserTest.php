<?php

namespace MD;

use MD\Testing\TestCase;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;

class AnalyserTest extends TestCase
{
    public function testBuildDefault()
    {
        $analyser = Analyser::buildDefault();
        $this->assertInstanceOf('MD\Analyser', $analyser);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAnalyseWithoutSourceString()
    {
        $analyser = Analyser::buildDefault();
        $analyser->analyse(new \stdClass());
    }

    public function testAnalyseWithEmptyRuleset()
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $analyser = new Analyser($parser, new NodeTraverser(), new RuleSet(), new Reporter());
        $analyser->analyse('<?php echo "test";');
        $this->assertEquals([], $analyser->getReporter()->getViolations());
    }

    public function testAnalyseValidCodeWithDefaultRuleset()
    {
        $analyser = Analyser::buildDefault();
        $analyser->analyse('<?php class Foo {}');
        $this->assertEquals([], $analyser->getReporter()->getViolations());
    }
}
