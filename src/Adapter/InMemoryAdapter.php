<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\MetricFamilySamples;
use Prometheus\Storage\InMemory;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class InMemoryAdapter extends AbstractAdapter
{
    public function __construct()
    {
        $this->adapter = new InMemory();
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->adapter->flushMemory();
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
        $this->adapter->updateGauge($data);
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
