<?php

namespace Component\Organic;

class Text
{
    protected $content;

    protected $elements;

    protected $orderedElements;

    protected $elementsConcentration;

    protected $separator;

    protected $parts;

    protected $partOccurrences;

    protected $orderedParts;

    protected $partsConcentration;

    function __construct($content)
    {
        $this->content = $content;
        $this->elements = array();

        $elements = str_split($content);

        foreach($elements as $element)
        {
            if(!isset($this->elements[$element])){
                $this->elements[$element] = 0;
            }

            $this->elements[$element]++;
        }

        // Order elements
        $orderedElements = $this->elements;

        arsort($orderedElements);

        $this->orderedElements = array_keys($orderedElements);

        // Process concentration
        $this->elementsConcentration = array();
        $totalCount = strlen($content);

        foreach($this->orderedElements as $element) {
            $count = $this->elements[$element];
            $this->elementsConcentration[$element] = round($count / $totalCount * 100, 2);
        }

        // Separator
        $this->separator = $this->orderedElements[0];

        // Parts
        $this->parts = explode($this->separator, $this->content);

        // Part occurrences
        $this->partOccurrences = array();

        foreach($this->parts as $part) {
            if(!isset($this->partOccurrences[$part])) {
                $this->partOccurrences[$part] = 0;
            }

            $this->partOccurrences[$part]++;
        }

        // Ordered partz
        $orderedParts = $this->partOccurrences;

        arsort($orderedParts);

        $this->orderedParts = array_keys($orderedParts);

        // Parts concentration
        $totalCount = array_sum($this->partOccurrences);

        foreach($this->parts as $part) {
            $count = $this->partOccurrences[$part];
            $this->partsConcentration[$part] = round($count / $totalCount * 100, 2);
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param mixed $elements
     */
    public function setElements($elements)
    {
        $this->elements = $elements;
    }

    public function getConcentration()
    {
        return round(count($this->elements) / strlen($this->content), 2);
    }

    public function getOrderedElements()
    {
        return $this->orderedElements;
    }

    public function getElementsConcentration()
    {
        return $this->elementsConcentration;
    }

    /**
     * @return mixed
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param mixed $separator
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function getPartOccurrences()
    {
        return $this->partOccurrences;
    }

    public function getOrderedParts()
    {
        return $this->orderedParts;
    }

    public function getPartsConcentration()
    {
        return $this->partsConcentration;
    }
}
