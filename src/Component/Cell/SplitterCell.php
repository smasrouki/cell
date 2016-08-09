<?php

namespace Component\Cell;

class SplitterCell extends ActiveCell
{
    protected $separator;

    public function __construct($content = null)
    {
        parent::__construct($content);

        $this->separator = $this->processSeparator();
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    public function setElements($elements)
    {
        parent::setElements($elements);

        $this->separator = $this->processSeparator();
    }


    public function processSeparator()
    {
        $element = $this->getElements();

        if (count($element)) {
            return array_shift($element);
        }

        return null;
    }

    public function getParts()
    {
        return explode($this->separator, $this->getContent());
    }
}
