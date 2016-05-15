<?php

namespace MD;

use MD\ParentConnector;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use PhpParser\ParserFactory;

class Analyser
{
    private $parser;
    private $traverser;
    private $ruleset;
    private $reporter;

    public static function buildDefault()
    {
        return new self(
            (new ParserFactory)->create(ParserFactory::PREFER_PHP7),
            new NodeTraverser(),
            Ruleset::buildDefault(),
            new Reporter()
        );
    }

    public function __construct(
        Parser $parser,
        NodeTraverser $traverser,
        Ruleset $ruleset,
        Reporter $reporter
    ) {
        $this->parser = $parser;
        $this->traverser = $traverser;
        $this->ruleset = $ruleset;
        $this->reporter = $reporter;
        $this->traverser->addVisitor(new NameResolver());
        $this->traverser->addVisitor(new ParentConnector());

        foreach ($ruleset->getRules() as $rule) {
            $rule->setReporter($reporter);
            $this->traverser->addVisitor($rule);
        }
    }

    public function analyse($source)
    {
        if (!is_string($source)) {
            throw new \InvalidArgumentException('Source must be a string');
        }

        $stmts = $this->parser->parse($source);
        $this->traverser->traverse($stmts);
    }

    public function analyseFile($file)
    {
        $this->reporter->setFile($file);
        $this->analyse(file_get_contents($file));
    }

    public function getReporter()
    {
        return $this->reporter;
    }
}
