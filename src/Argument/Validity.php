<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument;

class Validity implements ArgumentComponentInterface
{
    public function __construct(
        private readonly string $identifier,
        private readonly ValidityState $validityState,
    ) { }
}
