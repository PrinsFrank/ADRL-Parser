<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser;

use PrinsFrank\ADLParser\Argument\Component\Identity\Identity;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Modifier;
use PrinsFrank\ADLParser\Argument\ComponentSet;
use PrinsFrank\ADLParser\Argument\ComponentProvider\ComponentProvider;
use PrinsFrank\ADLParser\Argument\ComponentProvider\NativeComponentProvider;
use PrinsFrank\ADLParser\Context\ParserContext;
use PrinsFrank\ADLParser\Exception\DuplicateDefinitionException;
use PrinsFrank\ADLParser\Exception\InvalidComponentException;
use PrinsFrank\ADLParser\Exception\InvalidFileException;
use Throwable;

class Parser
{
    private readonly ComponentProvider $componentProvider;

    public function __construct(ComponentProvider|null $componentProvider = null)
    {
        $this->componentProvider = $componentProvider ?? new NativeComponentProvider();
    }

    /**
     * @throws InvalidFileException
     * @throws DuplicateDefinitionException
     * @throws InvalidComponentException
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

            $buffer = '';
            $keyword = $label = null;
            $identifiers = [];
            $context = ParserContext::None;
            $nrOfCharacters = mb_strlen($line);
            for ($i = 0; $i < $nrOfCharacters; $i++) {
                $char = mb_substr($line, $i, 1);
                if ($context === ParserContext::None) {
                    $context = ParserContext::Keyword;
                    $buffer .= $char;
                } elseif ($context === ParserContext::Keyword) {
                    if ($char === ' ') {
                        $context = ParserContext::Separator;
                        $keyword = $buffer;
                        $buffer = '';
                    } else {
                        $buffer .= $char;
                    }
                } elseif ($context === ParserContext::Separator) {
                    if ($char === '"') {
                        $context = ParserContext::Label;
                    } elseif ($char !== ' ') {
                        $context = ParserContext::Identifier;
                        $buffer .= $char;
                    }
                } elseif ($context === ParserContext::Identifier) {
                    if ($char === ' ') {
                        $context = ParserContext::Separator;
                        $identifiers[] = $buffer;
                        $buffer = '';
                    } else {
                        $buffer .= $char;
                    }
                } elseif ($context === ParserContext::Label) {
                    if ($char === '"') {
                        $context = ParserContext::End;
                        $label = $buffer;
                        $buffer = '';
                    } else {
                        $buffer .= $char;
                    }
                } else {
                    throw new InvalidComponentException('Unexpected character "' . $char . '" on line ' . $lineNo . ':' . $i . ' in context "' . $context->name . '"');
                }
            }

            match ($context) { // flush remaining buffers
                ParserContext::Identifier => $identifiers[] = $buffer,
                default => null,
            };

            /** @var class-string<Identity|Modifier> $componentFQN */
            $componentFQN = $this->componentProvider->provide()[$keyword] ?? throw new InvalidComponentException('Component with keyword "' . $keyword . '" doesn\'t exist');
            try {
                $component = $componentFQN::fromSet($identifiers, $label);
            } catch (Throwable $e) {
                throw new InvalidComponentException('Failed to parse line "' . $lineNo . '" (' . $line . ')', previous: $e);
            }
            $componentSet->addComponent($component);
        }

        fclose($resource);
        return $componentSet;
    }
}
