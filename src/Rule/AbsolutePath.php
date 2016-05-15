<?php

namespace MD\Rule;

use MD\Levels;
use MD\Reporter;
use MD\RuleInterface;
use MD\Tags;
use MD\Types;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Concat;

class AbsolutePath implements RuleInterface
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

    public function nodeType()
    {
        return Types::SCALAR_STRING;
    }

    public function apply(Node $node, Reporter $reporter)
    {
        if (($parent = $node->getAttribute('parent')) instanceof Concat) {
            if ($parent->getAttribute('children')[0] !== $node) {
                return; // doesn't apply if we're on the right side of a concatenation
            }
        }

        $isUnixAbsolute = preg_match('#^/[a-z]+#', $node->value);
        $isWindowsAbsolute = preg_match('#^[a-z]:/[a-z]+#i', $node->value);

        if ($isUnixAbsolute || $isWindowsAbsolute) {
            $reporter->addViolation("Found absolute path \"{$node->value}\"", $this, $node);
        }
    }
}
