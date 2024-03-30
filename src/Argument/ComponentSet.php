<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\FalseModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\InValidModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\TrueModifier;
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

    public function hasModifierOfType(string $identifier, string $fqn): bool
    {
        foreach ($this->modifiers[$identifier] ?? [] as $modifier) {
            if (is_a($modifier, $fqn, true) === true) {
                return true;
            }
        }

        return false;
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

    public function getPremiseState(Premise $identity): bool|null
    {
        $canBeTrue = null;
        foreach ($this->getModifiers($identity->identifier) as $modifier) {
            if ($modifier instanceof FalseModifier) {
                return false;
            }

            if ($modifier instanceof TrueModifier) {
                $canBeTrue = true;
            }
        }

        return $canBeTrue;
    }

    public function getConclusionState(Conclusion $identity): bool|null
    {
        foreach ($this->getModifiers($identity->identifier) as $modifier) {
            if ($modifier instanceof InValidModifier) {
                return false;
            }
        }

        $states = [];
        foreach ($identity->identifiers as $identifier) {
            $referencedIdentifier = $this->getIdentity($identifier);
            if ($referencedIdentifier instanceof Premise) {
                $states[] = $this->getPremiseState($referencedIdentifier);
            } elseif ($referencedIdentifier instanceof Conclusion) {
                $states[] = $this->getConclusionState($referencedIdentifier);
            }
        }

        if (in_array(false, $states, true) === true) {
            return false;
        }

        return in_array(null, $states, true) ? null : true;
    }
}
