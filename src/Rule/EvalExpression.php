<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\Eval_;

class EvalExpression extends AbstractRule
{
    public function name()
    {
        return 'eval';
    }

    public function description()
    {
        return 'eval() should never be used';
    }

    public function level()
    {
        return Levels::CRITICAL;
    }

    public function tags()
    {
        return [Tags::SECURITY];
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Eval_) {
            $this->reporter->addViolation("Found eval() call", $this, $node);
        }
    }
}
