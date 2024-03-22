<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

interface Modifier
{
    /**
     * @param list<string> $identifiers
     * @throws InvalidComponentException
     */
    public static function fromSet(array $identifiers, ?string $label): self;

    public function getIdentifier(): string;
}
