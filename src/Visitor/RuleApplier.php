<?php

namespace MD\Visitor;

use MD\Reporter;
use MD\Ruleset;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class RuleApplier extends NodeVisitorAbstract
{
    private $ruleset;
    private $reporter;

    public function __construct(Ruleset $ruleset, Reporter $reporter)
    {
        $this->ruleset = $ruleset;
        $this->reporter = $reporter;
    }

    public function enterNode(Node $node)
    {
        $rules = $this->ruleset->getRulesByType(get_class($node));

        foreach ($rules as $rule) {
            $rule->apply($node, $this->reporter);
        }
    }
}
