<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptFractor;
use Helmich\TypoScriptParser\Parser\AST\Statement;

abstract class AbstractTypoScriptFractor implements TypoScriptFractor
{
    protected File $file;

    protected bool $hasChanged = false;

    /**
     * @param list<Statement> $statements
     */
    public function beforeTraversal(File $file, array $statements): void
    {
        $this->file = $file;
    }

    /**
     * @return Statement|list<Statement>|int
     */
    public function enterNode(Statement $node): Statement|array|int
    {
        $result = $this->refactor($node);

        // no change => return unchanged node
        if ($result === null) {
            return $node;
        }

        return $result;
    }

    public function leaveNode(Statement $node): void
    {
    }

    /**
     * @param list<Statement> $statements
     */
    public function afterTraversal(array $statements): void
    {
    }
}
