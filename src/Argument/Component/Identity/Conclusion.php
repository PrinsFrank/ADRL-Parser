<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Identity;

use PrinsFrank\ADLParser\Exception\InvalidComponentException;

class Conclusion implements Identity
{
    public function __construct(
        public readonly string $identifier,
        public readonly string $label,
    ) {
    }

    /** @throws InvalidComponentException */
    public static function fromIdentifierAndContent(string $identifier, string $content): self
    {
        if (strlen($content) <= 2 || str_starts_with($content, '"') === false || str_ends_with($content, '"') === false) {
            throw new InvalidComponentException('Label should start and end with double quotes');
        }

        return new self($identifier, $content);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
