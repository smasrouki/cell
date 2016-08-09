<?php

namespace spec\Component\Cell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SplitterCellSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Cell\SplitterCell');
	    $this->shouldHaveType('Component\Cell\ActiveCell');
    }

    function it_should_have_a_separator()
    {
    	$this->setSeparator('s');
	    $this->getSeparator()->shouldReturn('s');
    }

    function it_should_process_separator_from_elements()
    {
        // No elements
        $this->processSeparator()->shouldReturn(null);

        $this->setElements(array('a', 'b'));
        $this->processSeparator()->shouldReturn('a');
    }

    function it_should_setup_separator_from_elements()
    {
        // No elements
        $this->getSeparator()->shouldReturn(null);

        $this->setElements(array('a', 'b'));
        $this->getSeparator()->shouldReturn('a');
    }

    function it_should_setup_separator_from_content()
    {
        $this->beConstructedWith('a#b#c');
        $this->getSeparator()->shouldReturn('#');
    }

    function it_should_process_parts_from_content()
    {
        $this->beConstructedWith('ab#cd#ef');

        $this->getParts()->shouldReturn(array('ab', 'cd', 'ef'));
    }
}
