<?php

namespace spec\Component\Cell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ActiveCellSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Cell\ActiveCell');
	    $this->shouldHaveType('Component\Cell\Cell');
    }

    function it_should_have_an_array_of_elements()
    {
        $elements = array('a', 'b', 'c');

        $this->setElements($elements);
        $this->getElements()->shouldReturn($elements);
    }

    function it_should_be_initialized_with_an_empty_set_of_elements()
    {
        $this->getElements()->shouldReturn(array());
    }

    function it_should_process_elements()
    {
        $this->setContent('abc');
        $this->processElements();
        $this->getElements()->shouldReturn(array('c', 'b', 'a'));
    }

    function it_should_process_elements_from_content()
    {
        $this->beConstructedWith('dfg');

        $this->getElements()->shouldReturn(array('g', 'f', 'd'));
    }

    function it_should_order_elements_by_occurences_count()
    {
        $this->beConstructedWith('dff');

        $this->getElements()->shouldReturn(array('f', 'd'));
    }
}
