<?php

namespace MD;

use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\NodeVisitor\NameResolver as BaseResolver;

/**
 * Name resolver storing fully qualified name in an dedicated
 * attribute instead of replacing the node itself (so that the
 * original name is kept).
 */
class NameResolver extends BaseResolver
{
    protected function resolveClassName(Name $name)
    {
        if (!$name instanceof FullyQualified) {
            $name->setAttribute('resolvedFqcn', parent::resolveClassName($name));
        }

        return $name;
    }

    protected function resolveOtherName(Name $name, $type)
    {
        if (!$name instanceof FullyQualified) {
            $name->setAttribute('resolvedFqcn', parent::resolveOtherName($name, $type));
        }

        return $name;
    }
}
