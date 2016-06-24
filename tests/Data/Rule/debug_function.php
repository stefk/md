<?php

var_dump(1);

function foo()
{
    print_r(new stdClass());
}

// var_dump in a comment

class Bar
{
    public function baz()
    {
        debug_zval_dump('123');

    }

    public function baz()
    {
        debug_print_backtrace();
    }
}

$wontApplyToThisCall();
