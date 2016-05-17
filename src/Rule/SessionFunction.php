<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

class SessionFunction extends AbstractRule
{
    private static $sessionFunctions = [
        'session_abort' => true,
        'session_cache_expire' => true,
        'session_cache_limiter' => true,
        'session_commit' => true,
        'session_decode' => true,
        'session_destroy' => true,
        'session_encode' => true,
        'session_get_cookie_params' => true,
        'session_id' => true,
        'session_is_registered' => true,
        'session_module_name' => true,
        'session_name' => true,
        'session_regenerate_id' => true,
        'session_register_shutdown' => true,
        'session_register' => true,
        'session_reset' => true,
        'session_save_path' => true,
        'session_set_cookie_params' => true,
        'session_set_save_handler' => true,
        'session_start' => true,
        'session_status' => true,
        'session_unregister' => true,
        'session_unset' => true,
        'session_write_close' => true,
    ];

    public function name()
    {
        return 'session_function';
    }

    public function description()
    {
        return 'PHP session functions should not be used';
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

        if (isset(static::$sessionFunctions[$function])) {
            $this->reporter->addViolation("Found {$function}() call", $this, $node);
        }
    }
}
