<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument;

class Conclusion implements ArgumentComponentInterface
{
    public function __construct(
        private readonly string $identifier,
        private readonly array $premises,
        private readonly ?string $label,
    ){ }
}
