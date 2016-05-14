<?php

namespace MD;

use MD\Reporter;
use PhpParser\Node;

interface RuleInterface
{
    function name();
    function description();
    function level();
    function tags();
    function nodeType();
    function apply(Node $node, Reporter $reporter);
}
