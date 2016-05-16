<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class PosixRegexFunctionTest extends RuleTestCase
{
    protected function getRule()
    {
        return new PosixRegexFunction();
    }
}
