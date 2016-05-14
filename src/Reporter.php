<?php

namespace MD;

use PhpParser\Node;

class Reporter
{
    private $violations = [];
    private $currentFile = '';

    public function setFile($file)
    {
        $this->currentFile = $file;
    }

    public function addViolation($message, RuleInterface $rule, Node $target)
    {
        $this->violations[$this->currentFile][] = [$message, $rule, $target];
    }

    public function getViolations()
    {
        return $this->violations;
    }
}
