<?php

namespace MD\Watcher;

use MD\AbstractWatcher;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class DebugFunctionWatcher extends AbstractWatcher
{
    private static $debugFunctions = [
        'var_dump' => true,
        'print_r' => true,
        'debug_zval_dump' => true,
        'debug_print_backtrace' => true,
    ];

    public function getRule()
    {
        return 'Debug functions should be removed';
    }

    public function getDescription()
    {
        return 'Debug functions should not be included in production code.';
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof FuncCall) {
            $function = $node->name->parts[0];

            if (isset(static::$debugFunctions[$function])) {
                $this->report("{$function} function detected", $node);
            }
        }
    }
}
