<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\ComponentProvider;

use PrinsFrank\ADLParser\Argument\Component\Identity\Conclusion;
use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Argument;
use PrinsFrank\ADLParser\Argument\Component\Modifier\InValid;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Sound;
use PrinsFrank\ADLParser\Argument\Component\Modifier\UnSound;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Valid;

class NativeComponentProvider implements ComponentProvider
{
    /** @return list<string, class-string<Identity|Modifier>> */
    public function provide(): array
    {
        return [
            'argument' => Argument::class,
            'conclusion' => Conclusion::class,
            'premise' => Premise::class,
            'sound' => Sound::class,
            'unsound' => UnSound::class,
            'valid' => Valid::class,
            'invalid' => InValid::class,
        ];
    }
}
