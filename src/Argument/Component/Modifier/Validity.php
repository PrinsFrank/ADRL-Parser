<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

use PrinsFrank\ADLParser\Argument\State\ValidityState;
use PrinsFrank\ADLParser\Exception\InvalidComponentException;
use PrinsFrank\Enums\BackedEnum;

class Validity implements Modifier
{
    public function __construct(
        public readonly string $identifier,
        public readonly ValidityState $validityState,
    ) {
    }

    public static function fromIdentifierAndContent(string $identifier, string $content): self
    {
        $validityState = ValidityState::tryFrom($content);
        if ($validityState === null) {
            throw new InvalidComponentException('ValidityState should be one of "' . implode(',', BackedEnum::values(ValidityState::class)) . '", "' . $content . '" given.');
        }

        return new self($identifier, $validityState);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
