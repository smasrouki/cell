<?php

namespace spec\Component\Text;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Text\Text');
    }

    function it_has_a_content()
    {
    	$content = 'Random content';
        $this->setContent($content);
        $this->getContent()->shouldReturn($content);
    }

    function it_could_be_construncted_with_content()
    {
    	$content = 'Random content';

    	$this->beConstructedWith($content);
    	$this->getContent()->shouldReturn($content);
    }

    function it_should_clean_content()
    {
        $content = "content#with\n\rnew#line###";

        $this->beConstructedWith($content);
        $this->getContent()->shouldReturn("content#with#new#line###");
    }

    function it_has_a_separator()
    {
        $separator = "#";
        $this->setSeparator($separator);
        $this->getSeparator()->shouldReturn($separator);
    }

    function it_has_parts()
    {
        $this->getParts()->shouldReturn(array());

        $notAnArray = 'not an array';
        $this->shouldThrow('\Exception')->duringSetParts($notAnArray);

        $parts = array('a', 'b', 'c');
        $this->setParts($parts);
        $this->getParts()->shouldReturn($parts);
    }

    function it_should_process_parts_form_content()
    {
        $content = 'a#b#cd#e\'F#g,';

        $this->beConstructedWith($content);
        $this->getparts()->shouldReturn(array('A', 'B', 'Cd', 'Ef', 'G'));
    }

    function it_should_process_part_occurence_rate_in_a_content()
    {
        $content = 'ab#cd#ef#gh#ab#ij#';

        $this->beConstructedWith($content);
        $this->getOccurrencesRate('Ab')->shouldReturn(33.3);
    }
}
