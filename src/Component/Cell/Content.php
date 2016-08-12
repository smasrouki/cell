<?php

namespace Component\Cell;

class Content
{
    protected $content;

    protected $elements = array();

    protected $separator;

    protected $parts = array();

    protected $pattern;

    public function __construct($content = null)
    {
        $this->content = $content;

        $this->init();
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setElements($elements)
    {
        $this->elements = $elements;

        $this->separator = $this->processSeparator();
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    public function setParts($parts)
    {
        $this->parts = $parts;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    protected function init()
    {
        if($this->content) {
            $this->processElements();
        }

        $this->separator = $this->processSeparator();

        if($this->separator) {
            $this->parts = $this->processParts();
        }

        $this->pattern = $this->processPattern();
    }

    public function processElements()
    {
        $count = count_chars($this->content, 1);
        arsort($count);

        $this->elements = array_map('chr', array_keys($count));
    }

    public function processSeparator()
    {
        $element = $this->elements;

        if (count($element)) {
            return array_shift($element);
        }

        return null;
    }

    protected function processParts()
    {
        $parts = array();

        foreach(explode($this->separator, $this->content) as $part) {
            if (strlen($part) > 1) {
                if(!isset($parts[$part])) {
                    $parts[$part] = 0;
                }

                $parts[$part]++;
            }
        }

        arsort($parts);

        return $parts;
    }

    public function processPattern()
    {
        $parts = array_keys($this->getParts());

        if(count($parts) && $this->separator) {
            return '/'.preg_quote($parts[0].$this->separator, '/').'(.*)/';
        }

        return null;
    }
}
