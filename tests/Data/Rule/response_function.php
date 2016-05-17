<?php

header('Location: http://foo.bar');

function foo()
{
    http_response_code(404);
}

class Bar
{
    public function baz()
    {
        setcookie('foo', '123');
    }

    public function baz()
    {
        setrawcookie('bar', '456');
    }
}
