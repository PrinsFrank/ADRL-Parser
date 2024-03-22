<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\ComponentProvider;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\InValidModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\TrueModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\FalseModifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\ValidModifier;

class NativeComponentProvider implements ComponentProvider
{
    /** @return array<string, class-string<Identity|Modifier>> */
    public function provide(): array
    {
        return [
            'conclusion' => Conclusion::class,
            'premise' => Premise::class,
            'true' => TrueModifier::class,
            'false' => FalseModifier::class,
            'valid' => ValidModifier::class,
            'invalid' => InValidModifier::class,
        ];
    }
}
