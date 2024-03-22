<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument;

use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Exception\DuplicateDefinitionException;
use PrinsFrank\ADLParser\Exception\InvalidComponentException;

class ComponentSet
{
    /** @var array<string, Identity> */
    private array $identities = [];

    /** @var array<string, list<Modifier>> */
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

    /** @return list<Modifier> */
    public function getModifiers(string $identifier): array
    {
        return $this->modifiers[$identifier] ?? [];
    }

    /** @throws InvalidComponentException */
    public function validate(): void
    {
        foreach ($this->modifiers as $identifier => $modifiers) {
            foreach ($modifiers as $modifier) {
                $identity = $this->getIdentity($identifier);
                if ($identity === null) {
                    throw new InvalidComponentException(sprintf('Modifier %s for non existing identity %s', $modifier->getIdentifier(), $identifier));
                }

                if ($modifier->appliesTo($identity) === false) {
                    throw new InvalidComponentException(sprintf('Modifier %s can\'t be applied to identity of type %s', $modifier->getIdentifier(), $identity::class));
                }
            }
        }
    }
}
