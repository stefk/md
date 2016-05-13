<?php

namespace MD;

use PhpParser\Node;

class Reporter
{
    private $messages = [];
    private $currentFile = '';

    public function setFile($file)
    {
        $this->currentFile = $file;
    }

    public function addMessage($message, AbstractWatcher $watcher, Node $target)
    {
        $this->messages[$this->currentFile][] = [$message, $watcher, $target];
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
