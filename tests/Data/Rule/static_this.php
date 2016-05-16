<?php

class Foo
{
    private static $z;
    private $bar;

    public static function a()
    {
        return $this->bar; // not ok
    }

    public function b()
    {
        x($this, $this->bar); // ok
    }

    protected static function c()
    {
        $baz = $this->a(); // not ok

        return $baz.$this->z; // not ok
    }
}
