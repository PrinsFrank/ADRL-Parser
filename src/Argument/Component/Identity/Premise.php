<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Identity;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

class Premise implements Identity
{
    public function __construct(
        public readonly string $identifier,
        public readonly string|null $label,
    ) {
    }

    /**
     * @param list<string> $identifiers
     * @throws InvalidComponentException
     */
    public static function fromSet(array $identifiers, ?string $label): self
    {
        if (array_key_exists(0, $identifiers) === false || count($identifiers) !== 1) {
            throw new InvalidComponentException('Expected exactly one identifier');
        }

        return new self($identifiers[0], $label);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function __toString()
    {
        return 'premise ' . $this->identifier . ($this->label !== null ? ' ' . $this->label : '');
    }
}
