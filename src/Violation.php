<?php

namespace MD;

use PhpParser\Node;

class Violation
{
    public $message;
    public $rule;
    public $file;
    public $startLine;
    public $endLine;

    public function __construct($message, AbstractRule $rule, Node $node, $file)
    {
        $this->message = $message;
        $this->rule = $rule;
        $this->file = $file;
        $this->startLine = $node->getAttribute('startLine');
        $this->endLine = $node->getAttribute('endLine');
    }

    public function toStdClass()
    {
        return (object) [
            'message' => $this->message,
            'rule' => $this->rule->name(),
            'startLine' => $this->startLine,
            'endLine' => $this->endLine,
        ];
    }

    public function __toString()
    {
        return sprintf(
            "In %s, line%s:\n   %s\n   %s",
            $this->file,
            $this->startLine === $this->endLine ?
                " {$this->startLine}" :
                "s {$this->startLine}-{$this->endLine}",
            $this->message,
            $this->rule->description()
        );
    }
}
