<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\Storage\Adapter;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 *
 * @property Adapter $adapter
 */
abstract class AbstractAdapter implements Adapter
{
    /**
     * @return void
     */
    abstract public function flush();

    /**
     * @return Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
