<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Exception\InvalidComponentException;
use Stringable;

interface Modifier extends Stringable
{
    /**
     * @param list<string> $identifiers
     * @throws InvalidComponentException
     */
    public static function fromSet(array $identifiers, ?string $label): self;

    public function getIdentifier(): string;

    public function appliesTo(Identity $identity): bool;
}
