<?php

namespace Jlis\PhpPrometheus\Collector;

use Jlis\PhpPrometheus\Adapter\InMemoryAdapter;
use Prometheus\CollectorRegistry;
use Prometheus\Counter;
use Prometheus\Gauge;
use Prometheus\Histogram;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class MetricsCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CollectorRegistry|\PHPUnit_Framework_MockObject_MockObject
     */
    private $registry;
    /**
     * @var MetricsCollector
     */
    private $collector;

    public function setUp()
    {
        parent::setUp();

        $this->registry = $this->createMock(CollectorRegistry::class);
        $this->collector = new MetricsCollector(new InMemoryAdapter(), $this->registry);
    }

    public function testIncrementCount()
    {
        $counter = $this->createMock(Counter::class);

        $this->registry->expects(static::once())
            ->method('getOrRegisterCounter')
            ->with('test', 'metric', null, [])
            ->willReturn($counter);

        $counter->expects(static::once())
            ->method('incBy')
            ->with(1, []);

        $this->collector
            ->setNamespace('test')
            ->incrementCount('metric');
    }

    public function testIncrementCountWithCustomValue()
    {
        $counter = $this->createMock(Counter::class);

        $this->registry->expects(static::once())
            ->method('getOrRegisterCounter')
            ->with('metrics', 'metric', null, ['key'])
            ->willReturn($counter);

        $counter->expects(static::once())
            ->method('incBy')
            ->with(1337, ['value']);

        $this->collector->incrementCount('metric', 1337, ['key' => 'value']);
    }

    public function testUpdateGauge()
    {
        $gauge = $this->createMock(Gauge::class);

        $this->registry->expects(static::once())
            ->method('getOrRegisterGauge')
            ->with('metrics', 'metric', null, ['key'])
            ->willReturn($gauge);

        $gauge->expects(static::once())
            ->method('set')
            ->with(1337, ['value']);

        $this->collector->updateGauge('metric', 1337, ['key' => 'value']);
    }

    public function testUpdateHistogram()
    {
        $histogram = $this->createMock(Histogram::class);

        $this->registry->expects(static::once())
            ->method('getOrRegisterHistogram')
            ->with('metrics', 'metric', null, ['key'], null)
            ->willReturn($histogram);

        $histogram->expects(static::once())
            ->method('observe')
            ->with(3.0, ['value']);

        $this->collector->updateHistogram('metric', 3.0, ['key' => 'value']);
    }

    public function testRender()
    {
        $this->registry->expects(static::once())
            ->method('getMetricFamilySamples')
            ->willReturn([]);

        $this->assertEquals("\n", $this->collector->render());
    }
}
