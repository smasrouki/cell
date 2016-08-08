<?php

namespace spec\Component\Breaker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BreakerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Breaker\Breaker');
    }

    function it_guess_the_best_separator_for_a_given_string()
    {
        $this->guessSeparator('')->shouldReturn(null);
        $this->guessSeparator('c')->shouldReturn('c');
        $this->guessSeparator('abbcccdddd')->shouldReturn('d');
        $this->guessSeparator('abb')->shouldReturn('b');
        $this->guessSeparator('a bb cxz dddd cxz')->shouldReturn(' ');
    }

    function it_decompose_a_string_with_a_guessed_separator()
    {
        $this->process('')->shouldReturn(array());
        $this->process('abacad')->shouldReturn(array('', 'b', 'c', 'd'));
    }

    function it_returns_the_most_used_keyword()
    {
        $this->processKeyword('')->shouldReturn(null);
        $this->processKeyword('a bb cxz dddd cxz')->shouldReturn('cxz');
    }

    function it_guess_a_pattern_to_break_a_string()
    {
        $this->guessPattern('')->shouldReturn(null);
        $this->guessPattern('a bb cxz dddd cxz')->shouldReturn('/cxz (.*)/');
    }
}
