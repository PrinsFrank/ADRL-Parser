<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

class Argument implements Modifier
{
    /** @param list<string> $identifiers */
    public function __construct(
        public readonly string $identifier,
        public readonly array $identifiers,
        public readonly string|null $label,
    ) {
    }

    /**
     * @param list<string> $identifiers
     * @throws InvalidComponentException
     */
    public static function fromSet(array $identifiers, ?string $label): self
    {
        if (array_key_exists(0, $identifiers) === false) {
            throw new InvalidComponentException('Expected one or more identifiers');
        }

        return new self($identifiers[0], array_slice($identifiers, 1), $label);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
