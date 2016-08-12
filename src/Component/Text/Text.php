<?php

namespace Component\Text;

class Text
{
    protected $content;

    protected $parts = array();

    protected $separator;

    public function __construct($content = null)
    {
        $this->content = $content;

        if ($this->content) {
            $this->processSeparator();

            $this->parts = explode($this->separator, $this->content);
        }
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setParts($parts)
    {
        if (!is_array($parts)) {
            throw new \Exception('Parts must be an array');
        }

        $this->parts = $parts;;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    protected function processSeparator()
    {
        $elements = count_chars($this->content, 1);
        arsort($elements);
        $keys = array_keys($elements);

        $this->separator = chr($keys[0]);
    }
}
