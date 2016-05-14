<?php

namespace MD;

use MD\Exception\DuplicateRuleNameException;
use MD\Exception\InvalidRuleDescriptionException;
use MD\Exception\InvalidRuleLevelException;
use MD\Exception\InvalidRuleNameException;
use MD\Exception\InvalidRuleTagsException;

class Ruleset
{
    private static $defaultRules = [
        'AbsolutePath',
        'DebugFunction',
    ];

    private $rules = [];
    private $rulesByType;

    public static function buildDefault()
    {
        $set = new self();

        foreach (static::$defaultRules as $rule) {
            $class = "MD\\Rule\\{$rule}";
            $set->addRule(new $class);
        }

        return $set;
    }

    public function addRule(RuleInterface $rule)
    {
        $this->assertValidName($rule);
        $this->assertValidDescription($rule);
        $this->assertValidLevel($rule);
        $this->assertValidTags($rule);
        $this->rules[$rule->name()] = $rule;
    }

    public function getRulesByType($type)
    {
        if (!$this->rulesByType) {
            foreach ($this->rules as $rule) {
                $this->rulesByType[$rule->nodeType()][] = $rule;
            }
        }

        if (!isset($this->rulesByType[$type])) {
            $this->rulesByType[$type] = [];
        }

        return $this->rulesByType[$type];
    }

    private function assertValidName(RuleInterface $rule)
    {
        if (!is_string($name = $rule->name())) {
            throw new InvalidRuleNameException('Rule name must be a string');
        }

        if (empty($name)) {
            throw new InvalidRuleNameException('Rule name cannot be empty');
        }

        if (isset($this->rules[$name])) {
            throw new DuplicateRuleNameException(
                "Rule name '{$name}' is already registered"
            );
        }
    }

    private function assertValidDescription(RuleInterface $rule)
    {
        if (!is_string($desc = $rule->description())) {
            throw new InvalidRuleDescriptionException('Rule description must be a string');
        }

        if (empty($desc)) {
            throw new InvalidRuleDescriptionException('Rule description cannot be empty');
        }
    }

    private function assertValidLevel(RuleInterface $rule)
    {
        if (!is_int($level = $rule->level())) {
            throw new InvalidRuleLevelException('Rule level must be an integer');
        }

        if (!Levels::isValid($level)) {
            throw new InvalidRuleLevelException('Invalid rule level');
        }
    }

    private function assertValidTags(RuleInterface $rule)
    {
        if (!is_array($tags = $rule->tags())) {
            throw new InvalidRuleTagsException('Rule tags must be an array');
        }

        if (count($tags) === 0) {
            throw new InvalidRuleTagsException('Rules require at least one tag');
        }

        foreach ($tags as $tag) {
            if (!is_string($tag)) {
                throw new InvalidRuleTagsException('Rule tag must be a string');
            }

            if (empty($tag)) {
                throw new InvalidRuleTagsException('Rule tag must cannot be empty');
            }
        }
    }
}
