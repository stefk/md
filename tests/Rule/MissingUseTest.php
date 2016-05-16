<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class MissingUseTest extends RuleTestCase
{
    protected function getRule()
    {
        return new MissingUse();
    }
}
