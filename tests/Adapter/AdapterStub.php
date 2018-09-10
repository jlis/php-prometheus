<?php

namespace Jlis\PhpPrometheus\Adapter;

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
}
