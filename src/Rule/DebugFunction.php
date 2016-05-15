<?php

namespace MD\Rule;

use MD\Levels;
use MD\Reporter;
use MD\RuleInterface;
use MD\Tags;
use MD\Types;
use PhpParser\Node;

class DebugFunction implements RuleInterface
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
        return 'Debug functions should not be included in production code.';
    }

    public function level()
    {
        return Levels::CRITICAL;
    }

    public function tags()
    {
        return [Tags::SECURITY];
    }

    public function nodeType()
    {
        return Types::EXPR_FUNC_CALL;
    }

    public function apply(Node $node, Reporter $reporter)
    {
        $function = $node->name->parts[0];

        if (isset(static::$debugFunctions[$function])) {
            $reporter->addViolation("{$function} function detected", $this, $node);
        }
    }
}
