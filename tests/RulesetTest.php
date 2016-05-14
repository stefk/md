<?php

namespace MD;

use MD\Testing\TestCase;
use MD\Types;

class RulesetTest extends TestCase
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

    public function testGetRulesByType()
    {
        $rule1 = $this->mockRule('foo', 'desc');
        $rule2 = $this->mockRule('bar', 'desc');
        $rule3 = $this->mockRule('baz', 'desc');

        $rule1->expects($this->once())->method('nodeType')->willReturn(Types::SCALAR_STRING);
        $rule2->expects($this->once())->method('nodeType')->willReturn(Types::SCALAR_STRING);
        $rule3->expects($this->once())->method('nodeType')->willReturn(Types::EXPR_FUNC_CALL);

        $set = new Ruleset();
        $set->addRule($rule1);
        $set->addRule($rule2);
        $set->addRule($rule3);

        $this->assertEquals([$rule1, $rule2], $set->getRulesByType(Types::SCALAR_STRING));
        $this->assertEquals([$rule3], $set->getRulesByType(Types::EXPR_FUNC_CALL));
        // ensure rules are cached (see once() constraints above)
        $this->assertEquals([$rule1, $rule2], $set->getRulesByType(Types::SCALAR_STRING));
        $this->assertEquals([$rule3], $set->getRulesByType(Types::EXPR_FUNC_CALL));
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
}
