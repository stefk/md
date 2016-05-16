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
    private $parentConcat;

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

    public function beforeTraverse(array $nodes)
    {
        $this->parentConcat = null;
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Concat) {
            $this->parentConcat = $node;
        }

        if (!$node instanceof String_) {
            return;
        }

        if ($this->parentConcat && $node === $this->parentConcat->right) {
            // doesn't apply if we're on the right side of a concatenation
            return;
        }

        $isUnixAbsolute = preg_match('#^/[a-z]+#', $node->value);
        $isWindowsAbsolute = preg_match('#^[a-z]:/[a-z]+#i', $node->value);

        if ($isUnixAbsolute || $isWindowsAbsolute) {
            $this->reporter->addViolation("Found absolute path \"{$node->value}\"", $this, $node);
        }
    }

    public function leaveNode(Node $node)
    {
        if ($node === $this->parentConcat) {
            $this->parentConcat = null;
        }
    }
}
