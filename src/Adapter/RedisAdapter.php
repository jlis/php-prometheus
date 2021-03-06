<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\MetricFamilySamples;
use Prometheus\Storage\Redis;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class RedisAdapter extends AbstractAdapter
{
    public function __construct(array $config = [])
    {
        $this->adapter = new Redis($config);
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->adapter->flushRedis();
    }

    /**
     * @return MetricFamilySamples[]
     * @throws \Prometheus\Exception\StorageException
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
