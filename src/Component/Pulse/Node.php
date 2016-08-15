<?php

namespace Component\Pulse;

use Component\Pulse\Pattern\Adapter\AdaptedInterface;
use Component\Pulse\Pattern\Adapter\AdapterInterface;

class Node implements AdaptedInterface
{
    protected $value = 'Node';

    protected $adapter;

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function process($value = null)
    {
        if ($this->adapter) {
            return $this->adapter->adapt($this->getValue());
        }

        return $this->getValue();
    }
}
