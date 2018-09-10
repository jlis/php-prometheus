<?php

namespace Jlis\PhpPrometheus\Adapter;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class AdapterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AdapterFactory
     */
    private $factory;

    public function setUp()
    {
        parent::setUp();

        $this->factory = new AdapterFactory();
    }

    /**
     * @dataProvider adapterTypeProvider
     *
     * @param string $type
     * @param string $expected
     */
    public function testMake($type, $expected)
    {
        $this->assertInstanceOf($expected, $this->factory->make($type));
    }

    /**
     * @return array
     */
    public function adapterTypeProvider()
    {
        return [
            ['memory', InMemoryAdapter::class],
        ];
    }

    public function testMakeWithUnknownAdapterType()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('Unknown metric adapter type "foo".');

        $this->factory->make('foo');
    }
}
