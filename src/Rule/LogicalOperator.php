<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\BinaryOp\LogicalXor;

class LogicalOperator extends AbstractRule
{
    public function name()
    {
        return 'logical_operator';
    }

    public function description()
    {
        return 'Logical operators should be avoided';
    }

    public function level()
    {
        return Levels::MAJOR;
    }

    public function tags()
    {
        return [Tags::BUGRISK];
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof LogicalAnd) {
            $this->reporter->addViolation("Found logical operator 'and'", $this, $node);
        } elseif ($node instanceof LogicalOr) {
            $this->reporter->addViolation("Found logical operator 'or'", $this, $node);
        } elseif ($node instanceof LogicalXor) {
            $this->reporter->addViolation("Found logical operator 'xor'", $this, $node);
        }
    }
}
