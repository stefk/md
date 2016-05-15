<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Reporter;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;

class DatabaseQuery extends AbstractRule
{
    public function name()
    {
        return 'database_query';
    }

    public function description()
    {
        return 'Database queries should use parameter binding';
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
        if (!$node instanceof Concat || !$node->left instanceof String_) {
            return;
        }

        if ($node->right instanceof String_ ||
            $node->right instanceof ClassConstFetch ||
            $node->right instanceof ConstFetch) {
            return;
        }

        $sqlRegex = '/^\s*select|insert|update|delete\s+[a-z_\*]+/i';
        $expr = $node->left->value;

        if (preg_match($sqlRegex, $expr)) {
            $this->reporter->addViolation("Found sql concat '{$expr}'", $this, $node);
        }
    }
}
