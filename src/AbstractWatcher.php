<?php

namespace MD;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

abstract class AbstractWatcher extends NodeVisitorAbstract
{
    private $reporter;

    abstract public function getRule();

    abstract public function getDescription();

    final public function setReporter(Reporter $reporter)
    {
        $this->reporter = $reporter;
    }

    final public function report($message, Node $target)
    {
        $this->reporter->addMessage($message, $this, $target);
    }
}
