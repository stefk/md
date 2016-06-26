<?php

namespace MD;

use PhpParser\Comment;
use PhpParser\NodeAbstract;

/**
 * Wraps comment in a "fake" node to ease reporting.
 */
class CommentNode extends NodeAbstract
{
    public function __construct(Comment $comment)
    {
        parent::__construct([
            'startLine' => $comment->getLine(),
            'endLine' => $comment->getLine()
        ]);
    }

    /**
     * @codeCoverageIgnore (not actually called, just there to satisfy interface)
     */
    public function getSubNodeNames() {}
}
