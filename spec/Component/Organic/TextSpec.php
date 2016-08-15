<?php

namespace spec\Component\Organic;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TextSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Initial content');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Organic\Text');
    }

    function it_has_a_content()
    {
        $this->getContent()->shouldReturn('Initial content');

        $content = 'Random content';

        $this->setContent($content);
        $this->getContent()->shouldReturn($content);
    }

    function it_has_elements()
    {
        $elements = array('a', 'b', 'c');

        $this->setElements($elements);
        $this->getElements()->shouldReturn($elements);
    }

    function it_should_process_elements_from_initial_content()
    {
        $result = array(
            'I' => 1,
            'n' => 3,
            'i' => 2,
            't' => 3,
            'a' => 1,
            'l' => 1,
            ' ' => 1,
            'c' => 1,
            'o' => 1,
            'e' => 1
        );

        $this->getElements()->shouldReturn($result);
    }

    function it_should_process_concentration_from_content()
    {
        // number of elements / content length
        $concentration = round(10 / 15, 2);

        $this->getConcentration()->shouldReturn($concentration);
    }

    function it_should_order_elements()
    {
        $result = array(
            'n', 't', 'i', 'o' , 'e', 'c', 'a', 'I', 'l', ' ',
        );

        $this->getOrderedElements()->shouldReturn($result);
    }

    function it_should_process_elements_concentration_from_content()
    {
        // number of occurrences / content length
        $result = array(
            'n' => round(3/15*100, 2),
            't' => round(3/15*100, 2),
            'i' => round(2/15*100, 2),
            'o' => round(1/15*100, 2),
            'e' => round(1/15*100, 2),
            'c' => round(1/15*100, 2),
            'a' => round(1/15*100, 2),
            'I' => round(1/15*100, 2),
            'l' => round(1/15*100, 2),
            ' ' => round(1/15*100, 2),
        );

        $this->getElementsConcentration()->shouldReturn($result);
    }

    function it_has_a_separator()
    {
        $separator = 'any';

        $this->setSeparator($separator);
        $this->getSeparator()->shouldReturn($separator);
    }

    function it_should_process_separator_from_content()
    {
        // First element
        $this->getSeparator()->shouldReturn('n');
    }

    function it_should_process_parts_from_content()
    {
        $result = array(
            'I',
            'itial co',
            'te',
            't'
        );

        $this->getParts()->shouldReturn($result);
    }

    function it_should_process_parts_occurences_from_content()
    {
        $result = array(
            'I' => 1,
            'itial co' => 1,
            'te' => 1,
            't' => 1,
        );

        $this->getPartOccurrences()->shouldReturn($result);
    }

    function it_should_order_parts()
    {
        $result = array(
            't',
            'te',
            'itial co',
            'I',
        );

        $this->getOrderedParts()->shouldReturn($result);
    }

    function it_should_process_parts_conccentration()
    {
        $result = array(
            'I' => 25.00,
            'itial co' => 25.00,
            'te' => 25.00,
            't' => 25.00,
        );

        $this->getPartsConcentration()->shouldReturn($result);
    }
}
