<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser;

use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\ComponentSet;
use PrinsFrank\ADLParser\Argument\ComponentProvider\ComponentProvider;
use PrinsFrank\ADLParser\Argument\ComponentProvider\NativeComponentProvider;
use PrinsFrank\ADLParser\Exception\DuplicateDefinitionException;
use PrinsFrank\ADLParser\Exception\InvalidFileException;
use PrinsFrank\ADLParser\Exception\InvalidIdentifierException;

class Parser
{
    private readonly ComponentProvider $componentProvider;

    public function __construct(ComponentProvider|null $componentProvider = null)
    {
        $this->componentProvider = $componentProvider ?? new NativeComponentProvider();
    }

    /**
     * @throws InvalidFileException
     * @throws InvalidIdentifierException
     * @throws DuplicateDefinitionException
     */
    public function parse(string $path): ComponentSet
    {
        $resource = fopen($path, 'rb');
        if ($resource === false) {
            throw new InvalidFileException("Unable to read file from $path");
        }

        $lineNo = 0;
        $componentSet = new ComponentSet($path);
        while (($line = fgets($resource)) !== false) {
            $lineNo++;
            if (($line = trim($line)) === '' || str_starts_with($line, '#') === true) {
                continue;
            }

            $firstSpacePos = mb_strpos($line, ' ');
            if ($firstSpacePos === false || $firstSpacePos === 0) {
                throw new InvalidFileException($lineNo . ': Each line should start with an identifier followed by a space or a "#" for a comment.');
            }

            $keyword = mb_substr($line, 0, $firstSpacePos);
            /** @var class-string<Identity|Modifier> $componentFQN */
            $componentFQN = $this->componentProvider->provide()[$keyword] ?? throw new InvalidFileException('keyword "' . $keyword . '" is not supported.');
            $componentString = mb_substr($line, mb_strlen($keyword) + 1);
            $componentParts = explode(' ', $componentString, 2);
            $identifier = $componentParts[0];
            $content = $componentParts[1] ?? null;
            if (preg_match('/^[a-z_]{2,}$/', $identifier) === false) {
                throw new InvalidIdentifierException($identifier);
            }

            $componentSet->addComponent($componentFQN::fromIdentifierAndContent($identifier, $content));
        }

        fclose($resource);
        return $componentSet;
    }
}
