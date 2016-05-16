<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class ExitExpressionTest extends RuleTestCase
{
    protected function getRule()
    {
        return new ExitExpression();
    }
}
