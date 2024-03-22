<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Identity;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

interface Identity
{
    /**
     * @param list<string> $identifiers
     * @throws InvalidComponentException
     */
    public static function fromSet(array $identifiers, ?string $label): self;

    public function getIdentifier(): string;
}
