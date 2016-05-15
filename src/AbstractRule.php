<?php

namespace MD;

use MD\Reporter;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

abstract class AbstractRule extends NodeVisitorAbstract
{
    protected $reporter;

    abstract public function name();
    abstract public function description();
    abstract public function level();
    abstract public function tags();

    public function setReporter(Reporter $reporter)
    {
        $this->reporter = $reporter;
    }
}
