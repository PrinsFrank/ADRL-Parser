<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Context;

enum ParserContext
{
    case None;
    case Keyword;
    case Separator;
    case Identifier;
    case Label;
    case End;
}
