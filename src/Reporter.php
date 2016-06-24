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

    public function getFile()
    {
        return $this->currentFile;
    }

    public function addViolation($message, AbstractRule $rule, Node $target)
    {
        $this->violations[] = new Violation($message, $rule, $target, $this->currentFile);
    }

    public function getViolations()
    {
        return $this->violations;
    }
}
