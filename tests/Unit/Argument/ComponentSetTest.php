<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Tests\Unit\Argument;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Sound;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Valid;
use PrinsFrank\ADLParser\Argument\ComponentSet;
use PrinsFrank\ADLParser\Exception\DuplicateDefinitionException;

#[CoversClass(ComponentSet::class)]
class ComponentSetTest extends TestCase
{
    public function testConstruct(): void
    {
        static::assertSame('foo', (new ComponentSet('foo'))->path);
    }

    /** @throws DuplicateDefinitionException */
    public function testIdentities(): void
    {
        $componentSet = new ComponentSet('');
        static::assertNull($componentSet->getIdentity('bop'));

        $premiseFoo = new Premise('foo', 'Foo');
        $componentSet->addComponent($premiseFoo);
        static::assertSame($premiseFoo, $componentSet->getIdentity('foo'));

        $conclusionBar = new Premise('bar', 'Bar');
        $componentSet->addComponent($conclusionBar);
        static::assertSame($conclusionBar, $componentSet->getIdentity('bar'));
    }

    /** @throws DuplicateDefinitionException */
    public function testModifiers(): void
    {
        $componentSet = new ComponentSet('');
        static::assertSame([], $componentSet->getModifiers('bop'));

        $validFoo = new Valid('foo');
        $componentSet->addComponent($validFoo);
        static::assertSame([$validFoo], $componentSet->getModifiers('foo'));

        $validBar = new Valid('bar');
        $componentSet->addComponent($validBar);
        $soundBar = new Sound('bar');
        $componentSet->addComponent($soundBar);
        static::assertSame([$validBar, $soundBar], $componentSet->getModifiers('bar'));
    }
}
