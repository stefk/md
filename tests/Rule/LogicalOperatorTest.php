<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class LogicalOperatorTest extends RuleTestCase
{
    protected function getRule()
    {
        return new LogicalOperator();
    }
}
