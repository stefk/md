<?php

namespace MD;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use PhpParser\ParserFactory;

class Analyser
{
    private $parser;
    private $traverser;
    private $reporter;
    private $watchers = [];

    public static function buildDefault()
    {
        return new self(
            (new ParserFactory)->create(ParserFactory::PREFER_PHP7),
            new NodeTraverser(),
            new Reporter()
        );
    }

    public function __construct(
        Parser $parser,
        NodeTraverser $traverser,
        Reporter $reporter
    ) {
        $this->parser = $parser;
        $this->traverser = $traverser;
        $this->reporter = $reporter;
        $this->traverser->addVisitor(new NameResolver());
    }

    public function addWatcher(AbstractWatcher $watcher)
    {
        $watcher->setReporter($this->reporter);
        $this->watchers[] = $watcher;
        $this->traverser->addVisitor($watcher);
    }

    public function analyse($source)
    {
        $stmts = $this->parser->parse($source);
        $this->traverser->traverse($stmts);

        return $this->reporter->getMessages();
    }
}
