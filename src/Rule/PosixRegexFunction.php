<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class PosixRegexFunction extends AbstractRule
{
    private static $regexFunctions = [
        'ereg_replace' => true,
        'ereg' => true,
        'eregi_replace' => true,
        'eregi' => true,
        'split' => true,
        'spliti' => true,
        'sql_regcase' => true,
    ];

    public function name()
    {
        return 'posix_regex_function';
    }

    public function description()
    {
        return 'POSIX regex functions should never be used';
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
        if (!$node instanceof FuncCall) {
            return;
        }

        $function = $node->name->parts[0];

        if (isset(static::$regexFunctions[$function])) {
            $this->reporter->addViolation("Found {$function}() call", $this, $node);
        }
    }
}
