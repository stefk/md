<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;

class DebugFunction extends AbstractRule
{
    private static $debugFunctions = [
        'var_dump' => true,
        'print_r' => true,
        'debug_zval_dump' => true,
        'debug_print_backtrace' => true,
    ];

    public function name()
    {
        return 'debug_function';
    }

    public function description()
    {
        return 'Debug functions should not be included in production code';
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
        if (!$node instanceof FuncCall || !$node->name instanceof Name) {
            return;
        }

        $function = $node->name->parts[0];

        if (isset(static::$debugFunctions[$function])) {
            $this->reporter->addViolation("Found {$function}() call", $this, $node);
        }
    }
}
