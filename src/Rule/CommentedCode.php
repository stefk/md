<?php

namespace MD\Rule;

use MD\AbstractRule;
use MD\CommentNode;
use MD\Levels;
use MD\Tags;
use PhpParser\Comment;
use PhpParser\Comment\Doc;
use PhpParser\Error;
use PhpParser\Node;
use PhpParser\ParserFactory;

class CommentedCode extends AbstractRule
{
    private $parser;
    private $seenComments = [];

    public function name()
    {
        return 'commented_code';
    }

    public function description()
    {
        return 'Commented code should not be committed';
    }

    public function level()
    {
        return Levels::MINOR;
    }

    public function tags()
    {
        return [Tags::DEADCODE];
    }

    public function enterNode(Node $node)
    {
        if (null === $comments = $node->getAttribute('comments')) {
            return;
        }

        foreach ($this->processComments($comments) as $comment) {
            $text = $comment->getText();

            if (0 !== strpos($text, '<?php')) {
                $text = '<?php '.$text;
            }

            try {
                $this->getParser()->parse($text);
                $wrapNode = new CommentNode($comment);
                $this->reporter->addViolation('Found commented code', $this, $wrapNode);
            } catch (Error $e) {}
        }
    }

    private function processComments(array $comments)
    {
        $processed = [];
        $previousLineComment = null;
        $previousCommentLineNumber = null;

        foreach ($comments as $comment) {
            if ($comment instanceof Doc || in_array($comment, $this->seenComments)) {
                continue;
            }

            $this->seenComments[] = $comment;
            $text = $comment->getReformattedText();

            if (0 === strpos($text, '/*')) {
                $text = substr(substr($text, 0, -2), 2); // remove comment delimiters
                $processed[] = new Comment($text, $comment->getLine(), $comment->getFilePos());
                continue;
            }

            $text = substr($text, 2);

            if (!$previousLineComment) {
                $previousLineComment = new Comment($text, $comment->getLine(), $comment->getFilePos());
                $previousCommentLineNumber = $comment->getLine();
                continue;
            }

            if ($previousCommentLineNumber !== $comment->getLine() - 1) {
                // line comments aren't consecutive
                $processed[] = $previousLineComment;
                $previousLineComment = new Comment($text, $comment->getLine(), $comment->getFilePos());
                $previousCommentLineNumber = $comment->getLine();
                continue;
            }

            // merge consecutive line comments
            $previousLineComment = new Comment(
                $previousLineComment->getText().$text,
                $previousLineComment->getLine(),
                $previousLineComment->getFilePos()
            );
            $previousCommentLineNumber = $comment->getLine();
        }

        if ($previousLineComment) {
            $processed[] = $previousLineComment;
        }

        return $processed;
    }

    private function getParser()
    {
        if (!$this->parser) {
            $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        }

        return $this->parser;
    }
}
