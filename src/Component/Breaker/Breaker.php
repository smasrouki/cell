<?php

namespace Component\Breaker;

class Breaker
{
    public function guessSeparator($string)
    {
        $maxCount = 0;
        $separator = null;

        if ($string) {
            foreach (count_chars($string) as $key => $count) {
                if($count > $maxCount) {
                    $maxCount = $count;
                    $separator = chr($key);
                }
            }
        }

        return $separator;
    }

    public function process($string)
    {
        $separator = $this->guessSeparator($string);

        if ($separator) {
            return explode($separator, $string);
        }

        return array();
    }

    public function processKeyword($string)
    {
        $keywords = array();

        foreach ($this->process($string) as $keyword) {
            if(strlen($keyword) > 1) {
                if (isset($keywords[$keyword])) {
                    $keywords[$keyword]++;
                } else {
                    $keywords[$keyword] = 1;
                }
            }
        }

        arsort($keywords);

        if(count($keywords) == 0) {
            return null;
        }

        $keys = array_keys($keywords);

        return $keys[0];
    }

    public function guessPattern($string)
    {
        $separator  = $this->guessSeparator($string);
        $keyword = $this->processKeyword($string);

        if ($separator && $keyword) {
            return '/'.preg_quote($keyword.$separator).'(.*)/';
        }

        return null;
    }
}
