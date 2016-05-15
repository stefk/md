<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class DatabaseQueryTest extends RuleTestCase
{
    protected function getRule()
    {
        return new DatabaseQuery();
    }
}
