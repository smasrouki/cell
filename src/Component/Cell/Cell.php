<?php

namespace Component\Cell;

class Cell
{
    protected $content;

    public function __construct($content = null)
    {
        $this->content = $content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}
