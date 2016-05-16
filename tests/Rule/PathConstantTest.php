<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class PathConstantTest extends RuleTestCase
{
    protected function getRule()
    {
        return new PathConstant();
    }
}
