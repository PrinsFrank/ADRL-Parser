<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\ComponentProvider;

use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;

interface ComponentProvider
{
    /** @return list<string, class-string<Identity|Modifier>> */
    public function provide(): array;
}
