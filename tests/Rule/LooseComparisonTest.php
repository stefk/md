<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class LooseComparisonTest extends RuleTestCase
{
    protected function getRule()
    {
        return new LooseComparison();
    }
}
