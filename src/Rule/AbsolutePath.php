<?php

namespace MD\Rule;

use MD\Levels;
use MD\Reporter;
use MD\RuleInterface;
use MD\Tags;
use MD\Types;
use PhpParser\Node;

class AbsolutePath implements RuleInterface
{
    public function name()
    {
        return 'absolute_path';
    }

    public function description()
    {
        return 'No absolute path should be hard-coded';
    }

    public function level()
    {
        return Levels::MINOR;
    }

    public function tags()
    {
        return [Tags::BUGRISK];
    }

    public function nodeType()
    {
        return Types::SCALAR_STRING;
    }

    public function apply(Node $node, Reporter $reporter)
    {
        throw new \Exception('Not implemented yet');
    }
}
