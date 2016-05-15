<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Scalar\String_;

class AbsolutePath extends AbstractRule
{
    public function name()
    {
        return 'absolute_path';
    }

    public function description()
    {
        return 'No absolute path should be hard-coded';
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
        if (!$node instanceof String_) {
            return;
        }

        if (($parent = $node->getAttribute('parent')) instanceof Concat) {
            if ($parent->getAttribute('children')[0] !== $node) {
                // doesn't apply if we're on the right side of a concatenation
                return;
            }
        }

        $isUnixAbsolute = preg_match('#^/[a-z]+#', $node->value);
        $isWindowsAbsolute = preg_match('#^[a-z]:/[a-z]+#i', $node->value);

        if ($isUnixAbsolute || $isWindowsAbsolute) {
            $this->reporter->addViolation("Found absolute path \"{$node->value}\"", $this, $node);
        }
    }
}
