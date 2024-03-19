<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Identity;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

interface Identity
{
    /** @throws InvalidComponentException */
    public static function fromIdentifierAndContent(string $identifier, string $content): self;

    public function getIdentifier(): string;
}
