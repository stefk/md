<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class SuperGlobalTest extends RuleTestCase
{
    protected function getRule()
    {
        return new SuperGlobal();
    }
}
