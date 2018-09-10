<?php

namespace Jlis\PhpPrometheus\Adapter;

use Prometheus\Storage\APC;

/**
 * @author Julius Ehrlich <julius@billomat.com>
 */
class ApcAdapter extends AbstractAdapter
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
}

