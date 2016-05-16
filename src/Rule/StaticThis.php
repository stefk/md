<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;

class StaticThis extends AbstractRule
{
    private $inStaticMethod = false;

    public function name()
    {
        return 'static_this';
    }

    public function description()
    {
        return 'Static method should not contain $this reference';
    }

    public function level()
    {
        return Levels::MAJOR;
    }

    public function tags()
    {
        return [Tags::BUGRISK];
    }

    public function beforeTraverse(array $nodes)
    {
        $this->inStaticMethod = false;
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof ClassMethod && $node->isStatic()) {
            $this->inStaticMethod = true;
        }

        if ($this->inStaticMethod && $node instanceof Variable && $node->name === 'this') {
            $this->reporter->addViolation("Found \$this reference in static method", $this, $node);
        }
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof ClassMethod && $node->isStatic()) {
            $this->inStaticMethod = false;
        }
    }
}
