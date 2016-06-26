<?php

namespace MD\Rule;

use MD\Testing\RuleTestCase;

class CommentedCodeTest extends RuleTestCase
{
    protected function getRule()
    {
        return new CommentedCode();
    }
}
