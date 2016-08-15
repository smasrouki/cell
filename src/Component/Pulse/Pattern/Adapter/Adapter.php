<?php

namespace Component\Pulse\Pattern\Adapter;

class Adapter implements AdapterInterface
{
    protected $adapted;

    /**
     * @return mixed
     */
    public function getAdapted()
    {
        return $this->adapted;
    }

    /**
     * @param mixed $adapted
     */
    public function setAdapted(AdaptedInterface $adapted)
    {
        $this->adapted = $adapted;
    }

    public function adapt($value)
    {
        if($this->adapted) {
            return $this->adapted->process($value);
        }

        return null;
    }
}
