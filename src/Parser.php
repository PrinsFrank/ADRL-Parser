<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser;

use PrinsFrank\ADLParser\Argument\ArgumentComponentInterface;
use PrinsFrank\ADLParser\Exception\InvalidFileException;

class Parser
{
    public function __construct(

    ) { }

    /**
     * @throws InvalidFileException
     * @return array<ArgumentComponentInterface>
     */
    public function parse(string $path): array
    {
        $resource = fopen($path, 'rb');
        if ($resource === false) {
            throw new InvalidFileException("Unable to read file from $path");
        }

        while (($line = fgets($resource)) !== false) {

        }

        fclose($resource);
    }
}
