<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class ResponseFunctionTest extends RuleTestCase
{
    protected function getRule()
    {
        return new ResponseFunction();
    }
}
