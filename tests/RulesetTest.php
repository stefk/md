<?php

namespace MD;

use MD\Levels;

class RulesetTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildDefault()
    {
        $set = Ruleset::buildDefault();
        $this->assertInstanceOf('MD\Ruleset', $set);
    }

    /**
     * @dataProvider invalidRuleInfoProvider
     * @expectedException \MD\Exception\InvalidRuleNameException
     */
    public function testAddRuleWithInvalidName($name)
    {
        $set = new Ruleset();
        $set->addRule($this->mockRule($name, 'desc'));
    }

    /**
     * @expectedException \MD\Exception\DuplicateRuleNameException
     */
    public function testAddRuleWithAlreadyRegisteredName()
    {
        $set = new Ruleset();
        $set->addRule($this->mockRule('foo', 'desc'));
        $set->addRule($this->mockRule('foo', 'desc'));
    }

    /**
     * @dataProvider invalidRuleInfoProvider
     * @expectedException \MD\Exception\InvalidRuleDescriptionException
     */
    public function testAddRuleWithInvalidDescription($description)
    {
        $set = new Ruleset();
        $set->addRule($this->mockRule('foo', $description));
    }

    /**
     * @dataProvider invalidRuleLevelProvider
     * @expectedException \MD\Exception\InvalidRuleLevelException
     */
    public function testAddRuleWithInvalidLevel($level)
    {
        $set = new Ruleset();
        $set->addRule($this->mockRule('foo', 'desc', $level));
    }

    /**
     * @dataProvider invalidRuleTagsProvider
     * @expectedException \MD\Exception\InvalidRuleTagsException
     */
    public function testAddRuleWithInvalidTags($tags)
    {
        $set = new Ruleset();
        $set->addRule($this->mockRule('foo', 'desc', Levels::INFO, $tags));
    }

    public function invalidRuleInfoProvider()
    {
        return [
            [null],
            [''],
            [[]],
            [new \stdClass()],
        ];
    }

    public function invalidRuleLevelProvider()
    {
        return [
            [null],
            ['0'],
            [123]
        ];
    }

    public function invalidRuleTagsProvider()
    {
        return [
            [null],
            [new \stdClass()],
            [['foo', true, 'bar']],
            [['foo', '', 'bar']],
            [[]],
        ];
    }

    protected function mockRule($name, $description, $level = Levels::INFO, $tags = false)
    {
        $rule = $this->getMock('MD\AbstractRule');
        $rule->expects($this->any())->method('name')->willReturn($name);
        $rule->expects($this->any())->method('description')->willReturn($description);
        $rule->expects($this->any())->method('level')->willReturn($level);
        $rule->expects($this->any())->method('tags')->willReturn($tags !== false ? $tags : ['foo']);

        return $rule;
    }
}
