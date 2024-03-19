<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument;

use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Exception\DuplicateDefinitionException;

class ComponentSet
{
    /** @var list<string, Identity|Modifier> */
    private array $identities = [];

    /** @var list<string, list<Identity|Modifier>> */
    private array $modifiers = [];

    public function __construct(
        public readonly string $path,
    ) {
    }

    /** @throws DuplicateDefinitionException */
    public function addComponent(Identity|Modifier $component): self
    {
        if ($component instanceof Modifier) {
            $this->modifiers[$component->getIdentifier()][] = $component;
        } else {
            if (array_key_exists($component->getIdentifier(), $this->identities)) {
                throw new DuplicateDefinitionException();
            }

            $this->identities[$component->getIdentifier()] = $component;
        }

        return $this;
    }

    public function getIdentity(string $identifier): ?Identity
    {
        return $this->identities[$identifier] ?? null;
    }

    public function getModifiers(string $identifier): array
    {
        return $this->modifiers[$identifier] ?? [];
    }
}
