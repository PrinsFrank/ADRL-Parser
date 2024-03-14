<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Exception;

use Throwable;

class InvalidFileException extends ADRLParserException
{
    public function __construct(string $message){
        parent::__construct($message);
    }
}
