<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\Variable;

class SuperGlobal extends AbstractRule
{
    private static $superGlobals = [
        'GLOBALS' => true,
        '_SERVER' => true,
        '_GET' => true,
        '_POST' => true,
        '_FILES' => true,
        '_COOKIE' => true,
        '_SESSION' => true,
        '_REQUEST' => true,
        '_ENV' => true,
    ];

    public function name()
    {
        return 'super_global';
    }

    public function description()
    {
        return 'PHP super globals should never be used';
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
        if (!$node instanceof Variable) {
            return;
        }

        if (isset(static::$superGlobals[$node->name])) {
            $this->reporter->addViolation("Found superglobal \${$node->name}", $this, $node);
        }
    }
}
