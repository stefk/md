<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class ResponseFunction extends AbstractRule
{
    private static $responseFunctions = [
        'header' => true,
        'http_response_code' => true,
        'setcookie' => true,
        'setrawcookie' => true,
    ];

    public function name()
    {
        return 'response_function';
    }

    public function description()
    {
        return 'PHP response functions should not be used';
    }

    public function level()
    {
        return Levels::MAJOR;
    }

    public function tags()
    {
        return [Tags::BUGRISK, Tags::SYMFONY];
    }

    public function enterNode(Node $node)
    {
        if (!$node instanceof FuncCall) {
            return;
        }

        $function = $node->name->parts[0];

        if (isset(static::$responseFunctions[$function])) {
            $this->reporter->addViolation("Found {$function}() call", $this, $node);
        }
    }
}
