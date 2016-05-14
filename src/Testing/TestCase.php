<?php

namespace MD\Testing;

use MD\Levels;
use MD\Types;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function mockRule($name, $description, $level = Levels::INFO, $tags = false)
    {
        $rule = $this->getMock('MD\RuleInterface');
        $rule->expects($this->any())->method('name')->willReturn($name);
        $rule->expects($this->any())->method('description')->willReturn($description);
        $rule->expects($this->any())->method('level')->willReturn($level);
        $rule->expects($this->any())->method('tags')->willReturn($tags !== false ? $tags : ['foo']);

        return $rule;
    }
}
