<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\NotEqual;

class LooseComparison extends AbstractRule
{
    public function name()
    {
        return 'loose_comparison';
    }

    public function description()
    {
        return 'Loose comparisons should be avoided';
    }

    public function level()
    {
        return Levels::MINOR;
    }

    public function tags()
    {
        return [Tags::BUGRISK];
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Equal) {
            $this->reporter->addViolation("Found operator '=='", $this, $node);
        } elseif ($node instanceof NotEqual) {
            $this->reporter->addViolation("Found operator '!='", $this, $node);
        }
    }
}
