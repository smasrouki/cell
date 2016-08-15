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
            $this->clean();
            $this->processParts();
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


    public function getOccurrencesRate($search)
    {
        $count = 0;
        $total = count($this->getParts());

        foreach($this->getParts() as $part) {
            if($part == $search) {
                $count++;
            }
        }

        return round(($count / $total) * 100, 1);
    }

    protected function processSeparator()
    {
        $elements = count_chars($this->content, 1);
        arsort($elements);
        $keys = array_keys($elements);

        $this->separator = chr($keys[0]);
    }

    protected function processParts()
    {
        $parts = array();

        foreach (explode($this->separator, $this->content) as $part) {
            $part = $this->cleanPart($part);

            if ($part) {
                $parts[] = $part;
            }
        }

        $this->parts = $parts;
    }

    protected function cleanPart($part)
    {
        $search = array("'", ",", ".", ":", "\n", "\r", ";", "!", "(", ")", "=", "?");
        $part = str_replace($search, '', $part);

        $reservedKeywords = array('__halt_compiler', 'abstract', 'and', 'array', 'as', 'break', 'callable', 'case', 'catch', 'class', 'clone', 'const', 'continue', 'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'final', 'for', 'foreach', 'function', 'global', 'goto', 'if', 'implements', 'include', 'include_once', 'instanceof', 'insteadof', 'interface', 'isset', 'list', 'namespace', 'new', 'or', 'print', 'private', 'protected', 'public', 'require', 'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'try', 'unset', 'use', 'var', 'while', 'xor');
        $part = str_replace($reservedKeywords, '', strtolower($part));

        $part = $this->ucfirst($part);
        $part = trim($part);

        if(intval($part)){
            return '';
        }

        return $part;
    }

    protected function ucFirst($str) {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }

    protected function clean()
    {
        $search = array("\n\r", "\n", "\r", "-");

        $content = str_replace($search, $this->separator, $this->content);

        $this->content = $content;
    }
}
