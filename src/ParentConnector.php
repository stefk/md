<?php

namespace MD;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * Visitor adding "parent" and children node attribute on each node.
 *
 * see https://github.com/nikic/PHP-Parser/issues/238
 */
class ParentConnector extends NodeVisitorAbstract
{
    private $stack;

    public function beginTraverse(array $nodes)
    {
        $this->stack = [];
    }

    public function enterNode(Node $node)
    {
        if (!$node->hasAttribute('children')) {
            $node->setAttribute('children', []);
        }

        if (!empty($this->stack)) {
            $parent = $this->stack[count($this->stack) - 1];
            $node->setAttribute('parent', $parent);
            $parent->getAttribute('children')[] = $node;
        }

        $this->stack[] = $node;
    }

    public function leaveNode(Node $node)
    {
        array_pop($this->stack);
    }
}
