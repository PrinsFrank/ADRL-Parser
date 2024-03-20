<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

use PrinsFrank\ADLParser\Exception\InvalidIdentifierException;

class Argument implements Modifier
{
    /** @param list<string> $identifiers */
    public function __construct(
        public readonly string $identifier,
        public readonly array $identifiers,
    ) {
    }

    /** @throws InvalidIdentifierException */
    public static function fromIdentifierAndContent(string $identifier, ?string $content): self
    {
        $identifiers = explode(' ', $content ?? '');
        foreach ($identifiers as $argumentSource) {
            if (preg_match('/^[a-z_]+$/', $argumentSource) === false) {
                throw new InvalidIdentifierException($argumentSource);
            }
        }

        return new self($identifier, $identifiers);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
