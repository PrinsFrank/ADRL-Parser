<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

interface Modifier
{
    /** @throws InvalidComponentException */
    public static function fromIdentifierAndContent(string $identifier, string $content): self;

    public function getIdentifier(): string;
}
