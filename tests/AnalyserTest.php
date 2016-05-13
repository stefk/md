<?php

namespace MD;

use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;

class AnalyserTest extends \PHPUnit_Framework_TestCase
{
    private $analyser;

    protected function setUp()
    {
        $this->analyser = Analyser::buildDefault();
    }

    public function testNoWatchers()
    {
        $messages = $this->analyser->analyse('<?php echo "test";');
        $this->assertEquals([], $messages);
    }

    public function testDummyWatchers()
    {
        $watcher1 = $this->getMock('MD\AbstractWatcher');
        $watcher2 = $this->getMock('MD\AbstractWatcher');

        $this->analyser->addWatcher($watcher1);
        $this->analyser->addWatcher($watcher2);

        $node1 = $this->getMock('PhpParser\Node');
        $node2 = $this->getMock('PhpParser\Node');

        $watcher1->report('foo', $node1);
        $watcher1->report('bar', $node2);
        $watcher2->report('baz', $node2);

        $messages = $this->analyser->analyse('<?php echo "test";');
        $expected = ['' => [
            ['foo', $watcher1, $node1],
            ['bar', $watcher1, $node2],
            ['baz', $watcher2, $node2],
        ]];
        $this->assertEquals($expected, $messages);
    }
}
