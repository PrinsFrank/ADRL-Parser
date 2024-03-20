<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

class Valid implements Modifier
{
    public function __construct(
        public readonly string $identifier,
    ) {
    }

    public static function fromIdentifierAndContent(string $identifier, ?string $content): self
    {
        return new self($identifier);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
