<?php

namespace Foo;

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
