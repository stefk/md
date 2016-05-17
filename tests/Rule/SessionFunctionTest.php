<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class SessionFunctionTest extends RuleTestCase
{
    protected function getRule()
    {
        return new SessionFunction();
    }
}
