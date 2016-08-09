<?php

namespace Component\Cell;

class ActiveCell extends Cell
{
    protected $elements = array();

    /**
     * ActiveCell constructor.
     * @param string $content
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        if($this->getContent()) {
            $this->processElements();
        }
    }


    public function setElements($elements)
    {
        $this->elements = $elements;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function processElements()
    {
        $count = count_chars($this->getContent(), 1);
        arsort($count);

        $this->elements = array_map('chr', array_keys($count));
    }
}
