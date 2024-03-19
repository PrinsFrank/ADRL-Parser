<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\ComponentProvider;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Argument;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Soundness;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Validity;

class NativeComponentProvider implements ComponentProvider
{
    /** @return list<string, class-string<Identity|Modifier>> */
    public function provide(): array
    {
        return [
            'argument' => Argument::class,
            'conclusion' => Conclusion::class,
            'premise' => Premise::class,
            'soundness' => Soundness::class,
            'validity' => Validity::class,
        ];
    }
}
