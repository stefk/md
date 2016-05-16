<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class StaticThisTest extends RuleTestCase
{
    protected function getRule()
    {
        return new StaticThis();
    }
}
