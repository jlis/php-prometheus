<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\Storage\InMemory;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
final class AdapterFactory
{
    /**
     * @var AbstractAdapter[]
     */
    private $adapters = [];

    public function __construct()
    {
        $this->add('memory', InMemory::class);
        $this->add('apcu', ApcAdapter::class);
        $this->add('redis', RedisAdapter::class);
    }

    /**
     * @param string $type
     * @param string|AbstractAdapter
     */
    public function add($type, $adapter)
    {
        if (is_string($adapter) && class_exists($adapter)) {
            $adapter = new $adapter;
        }

        if (!$adapter instanceof AbstractAdapter) {
            throw new \RuntimeException('Invalid metric adapter given: ' . gettype($adapter));
        }

        $this->adapters[$type] = $adapter;
    }

    /**
     * @param string $type
     *
     * @return AbstractAdapter
     */
    public function make($type)
    {
        if (!isset($this->adapters[$type])) {
            throw new \OutOfBoundsException("Unknown metric adapter type \"{$type}\".");
        }

        return $this->adapters[$type];
    }
}
