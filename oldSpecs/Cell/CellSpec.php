<?php

namespace spec\Component\Cell;

use Component\Cell\Cell;
use Component\Cell\Content;
use Component\Cell\PatternProviderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CellSpec extends ObjectBehavior
{
    public function let(Content $content, PatternProviderInterface $patternProvider)
    {
        $this->beConstructedWith($content, $patternProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Cell\Cell');
        $this->shouldImplement('Component\Cell\PatternProviderInterface');
    }

    function it_should_have_a_content(Content $content)
    {
        $this->setContent($content);
        $this->getContent()->shouldHaveType('Component\Cell\Content');
    }

    function it_should_be_constructed_with_a_content_and_a_pattern_provider(PatternProviderInterface $patternProvider)
    {
        $this->getPatternProvider()->shouldHaveType('Component\Cell\PatternProviderInterface');
        $this->getContent()->shouldHaveType('Component\Cell\Content');
    }

    function it_should_process_pattern_from_its_decorator(Content $content, PatternProviderInterface $patternProvider)
    {
        $patternProvider->getPattern()->willReturn('/keyword (.*)/');
        $content->getPattern()->willReturn('/keyword1 (.*)/');
        $content->getContent()->willReturn('Anything');

        $this->getPattern()->shouldReturn('/keyword keyword1 (.*)/');
    }

    function it_should_have_matches()
    {
        $this->getMatches()->shouldReturn(array());

        $matches = array('match1', 'match2');

        $this->setMatches($matches);
        $this->getMatches()->shouldReturn($matches);
    }

    function it_should_process_matches_from_its_decorator(Content $content, PatternProviderInterface $patternProvider)
    {
        $patternProvider->getPattern()->willReturn(null);
        $content->getPattern()->willReturn('/keyword (.*)/');
        $content->getContent()->willReturn("keyword match1\n keyword match2\n/");

        $this->getMatches()->shouldReturn(array('match1', 'match2'));
    }
}
