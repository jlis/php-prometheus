<?php

namespace Jlis\PhpPrometheus\Adapter;

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
}
