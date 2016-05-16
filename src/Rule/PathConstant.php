<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpParser\Node\Scalar\MagicConst\File;

class PathConstant extends AbstractRule
{
    public function name()
    {
        return 'path_constant';
    }

    public function description()
    {
        return 'Absolute path constants __DIR__ and __FILE__ should not be used';
    }

    public function level()
    {
        return Levels::MAJOR;
    }

    public function tags()
    {
        return [Tags::BUGRISK];
    }

    public function enterNode(Node $node)
    {
        if ($node instanceof Dir) {
            $this->reporter->addViolation("Found __DIR__ constant", $this, $node);
        } elseif ($node instanceof File) {
            $this->reporter->addViolation("Found __FILE__ constant", $this, $node);
        }
    }
}
