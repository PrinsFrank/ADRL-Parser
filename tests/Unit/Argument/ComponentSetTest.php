<?php
declare(strict_types=1);

namespace PrinsFrank\ADLParser\Tests\Unit\Argument;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PrinsFrank\ADLParser\Argument\Component\Identity\Premise;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Sound;
use PrinsFrank\ADLParser\Argument\Component\Modifier\Valid;
use PrinsFrank\ADLParser\Argument\ComponentSet;

#[CoversClass(ComponentSet::class)]
class ComponentSetTest extends TestCase
{
    public function testConstruct(): void
    {
        static::assertSame('foo', (new ComponentSet('foo'))->path);
    }

    public function testIdentities(): void
    {
        $componentSet = new ComponentSet('');

        $premiseFoo = new Premise('foo', 'Foo');
        $componentSet->addComponent($premiseFoo);

        $conclusionBar = new Premise('bar', 'Bar');
        $componentSet->addComponent($conclusionBar);

        static::assertSame($premiseFoo, $componentSet->getIdentity('foo'));
        static::assertSame($conclusionBar, $componentSet->getIdentity('bar'));
        static::assertNull($componentSet->getIdentity('bop'));
    }

    public function testModifiers(): void
    {
        $componentSet = new ComponentSet('');

        $validFoo = new Valid('foo');
        $componentSet->addComponent($validFoo);

        $validBar = new Valid('bar');
        $componentSet->addComponent($validBar);

        $soundBar = new Sound('bar');
        $componentSet->addComponent($soundBar);

        static::assertSame([$validFoo], $componentSet->getModifiers('foo'));
        static::assertSame([$validBar, $soundBar], $componentSet->getModifiers('bar'));
        static::assertSame([], $componentSet->getModifiers('bop'));
    }
}
