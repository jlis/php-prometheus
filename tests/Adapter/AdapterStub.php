<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\MetricFamilySamples;
use Prometheus\Storage\Adapter;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
final class AdapterStub extends AbstractAdapter
{
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function flush()
    {
        $this->adapter->flush();
    }

    /**
     * @return MetricFamilySamples[]
     */
    public function collect()
    {
        return $this->adapter->collect();
    }

    /**
     * @param array $data
     */
    public function updateHistogram(array $data)
    {
        $this->adapter->updateHistogram($data);
    }

    /**
     * @param array $data
     */
    public function updateGauge(array $data)
    {
        $this->adapter->updateGauge($data);
    }

    /**
     * @param array $data
     */
    public function updateCounter(array $data)
    {
        $this->adapter->updateCounter($data);
    }
}
