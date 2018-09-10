<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\Storage\Adapter;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class AbstractAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Adapter
     */
    private $mock;
    /**
     * @var AdapterStub
     */
    private $adapter;

    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->getMockBuilder(Adapter::class)
            ->setMethods([
                'flush',
                'getAdapter',
                'collect',
                'updateHistogram',
                'updateGauge',
                'updateCounter',
            ])
            ->getMock();

        $this->adapter = new AdapterStub($this->mock);
    }

    public function testGetAdapter()
    {
        $this->assertEquals($this->mock, $this->adapter->getAdapter());
    }

    public function testFlush()
    {
        $this->mock->expects(static::once())
            ->method('flush');

        $this->adapter->flush();
    }
}
