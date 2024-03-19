<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\Component\Modifier;

use PrinsFrank\ADLParser\Argument\State\SoundnessState;
use PrinsFrank\ADLParser\Exception\InvalidComponentException;
use PrinsFrank\Enums\BackedEnum;

class Soundness implements Modifier
{
    public function __construct(
        public readonly string $identifier,
        public readonly SoundnessState $soundnessState,
    ) {
    }

    /** @throws InvalidComponentException */
    public static function fromIdentifierAndContent(string $identifier, string $content): self
    {
        $soundnessState = SoundnessState::tryFrom($content);
        if ($soundnessState === null) {
            throw new InvalidComponentException('SoundnessState should be one of "' . implode(',', BackedEnum::values(SoundnessState::class)) . '", "' . $content . '" given.');
        }

        return new self($identifier, $soundnessState);
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
