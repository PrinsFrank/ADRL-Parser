<?php declare(strict_types=1);

namespace PrinsFrank\ADLParser\Argument\State;

enum ValidityState: string
{
    case valid = 'valid';
    case invalid = 'invalid';
}
