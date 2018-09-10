<?php

namespace Jlis\PhpPrometheus\Adapter;

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
}
