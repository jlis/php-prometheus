<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\MetricFamilySamples;
use Prometheus\Storage\APC;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class ApcuAdapter extends AbstractAdapter
{
    public function __construct()
    {
        $this->adapter = new APC();
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->adapter->flushAPC();
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
