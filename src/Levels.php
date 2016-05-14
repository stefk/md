<?php

namespace MD;

class Levels
{
    const INFO = 0;
    const MINOR = 1;
    const MAJOR = 2;
    const CRITICAL = 3;

    private static $levels = [
        self::INFO,
        self::MINOR,
        self::MAJOR,
        self::CRITICAL,
    ];

    public static function isValid($level)
    {
        return in_array($level, static::$levels);
    }
}
