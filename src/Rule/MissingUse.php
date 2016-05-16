<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\Levels;
use MD\Tags;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;

class MissingUse extends AbstractRule
{
    public function name()
    {
        return 'missing_use';
    }

    public function description()
    {
        return 'Missing use statement should be avoided';
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
        if ($node instanceof FullyQualified) {
            if (count($node->parts) === 1) {
                // if there's only one part, the name belongs to the
                // global/std namespace and we can tolerate a missing use
                return;
            }

            $name = implode('\\', $node->parts);
            $this->reporter->addViolation("Found fully qualified name '{$name}'", $this, $node);
        }
    }
}
