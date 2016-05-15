<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class EvalExpressionTest extends RuleTestCase
{
    protected function getRule()
    {
        return new EvalExpression();
    }
}
