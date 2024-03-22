<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Identity;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

class Conclusion implements Identity
{
    /** @param array<string> $identifiers */
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
        if (array_key_exists(0, $identifiers) === false || count($identifiers) < 2) {
            throw new InvalidComponentException('Expected 2 or more identifiers');
        }

        $linkedIdentifiers = array_slice($identifiers, 1);
        if (in_array($identifiers[0], $linkedIdentifiers, true) === true) {
            throw new InvalidComponentException('A Conclusion cannot reference itself');
        }

        return new self($identifiers[0], $linkedIdentifiers, $label);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function __toString()
    {
        return 'conclusion ' . $this->identifier . ($this->label !== null ? ' ' . $this->label : '');
    }
}
