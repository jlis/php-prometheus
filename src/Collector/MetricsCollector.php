<?php

namespace Jlis\PhpPrometheus\Collector;

use Jlis\PhpPrometheus\Adapter\AbstractAdapter;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class MetricsCollector
{
    /**
     * @var CollectorRegistry
     */
    private $registry;
    /**
     * @var string
     */
    private $namespace = 'metrics';
    /**
     * @var AbstractAdapter
     */
    private $adapter;

    /**
     * @param AbstractAdapter $adapter
     * @param CollectorRegistry|null $registry
     */
    public function __construct(AbstractAdapter $adapter, CollectorRegistry $registry = null)
    {
        $this->adapter = $adapter;
        $this->registry = $registry ?: new CollectorRegistry($this->adapter->getAdapter());
    }

    /**
     * @param string $namespace
     *
     * @return void
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @param string $metric
     * @param int $value
     * @param array $labels
     *
     * @return MetricsCollector
     */
    public function incrementCount($metric, $value = 1, array $labels = [])
    {
        $counter = $this->registry->getOrRegisterCounter($this->namespace, $metric, null, array_keys($labels));
        $counter->incBy($value, array_values($labels));

        return $this;
    }

    /**
     * @param string $metric
     * @param float $value
     * @param array $labels
     *
     * @return MetricsCollector
     */
    public function updateGauge($metric, $value, array $labels = [])
    {
        $gauge = $this->registry->getOrRegisterGauge($this->namespace, $metric, null, array_keys($labels));
        $gauge->set($value, array_values($labels));

        return $this;
    }

    /**
     * @param string $metric
     * @param float $value
     * @param array $labels
     * @param array|null $buckets
     *
     * @return MetricsCollector
     */
    public function updateHistogram($metric, $value, array $labels = [], $buckets = null)
    {
        $histogram = $this->registry->getOrRegisterHistogram($this->namespace, $metric, null, array_keys($labels),
            $buckets);
        $histogram->observe($value, array_values($labels));

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $renderer = new RenderTextFormat();
        $metrics = $renderer->render($this->registry->getMetricFamilySamples());

        $this->adapter->flush();

        return $metrics;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return RenderTextFormat::MIME_TYPE;
    }
}
