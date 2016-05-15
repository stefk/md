<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class AbsolutePathTest extends RuleTestCase
{
    protected function getRule()
    {
        return new AbsolutePath();
    }
}
