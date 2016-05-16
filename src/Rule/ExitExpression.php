<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\Exit_;

class ExitExpression extends AbstractRule
{
    public function name()
    {
        return 'exit_expression';
    }

    public function description()
    {
        return 'exit() and die() expressions should be avoided';
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
        if (!$node instanceof Exit_) {
            return;
        }

        $name = $node->getAttribute('kind') === Exit_::KIND_EXIT ? 'exit' : 'die';
        $this->reporter->addViolation("Found {$name}() call", $this, $node);
    }
}
