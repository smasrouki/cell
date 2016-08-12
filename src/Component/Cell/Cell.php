<?php

namespace Component\Cell;

class Cell implements PatternProviderInterface
{
    protected $content;

    protected $patternProvider;

    protected $matches = array();

    public function __construct(Content $content, PatternProviderInterface $patternProvider = null)
    {
        $this->content = $content;
        $this->patternProvider = $patternProvider;

        if($this->getPattern()) {
            $results = null;
            preg_match_all($this->getPattern(), $this->content->getContent(), $results);
            $this->matches = $results[1];
        }
    }

    public function setContent(Content $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setPatternProvider(PatternProviderInterface $patternProvider)
    {
        $this->patternProvider = $patternProvider;
    }

    public function getPatternProvider()
    {
        return $this->patternProvider;
    }

    public function setMatches($matches)
    {
        $this->matches = $matches;
    }

    public function getMatches()
    {
        return $this->matches;
    }

    public function getPattern()
    {
        $pattern = $this->content->getPattern();

        if($this->patternProvider && $this->patternProvider->getPattern()) {
            $subPattern = substr($pattern, 1, strlen($pattern) - 2);
            $pattern = str_replace('(.*)', $subPattern, $this->patternProvider->getPattern());
        }

        return $pattern;
    }
}
