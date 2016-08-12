<?php

namespace spec\Component\Cell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Cell\Content');
    }

    function it_should_have_content()
    {
    	$content = 'Random content';

    	$this->setContent($content);
	    $this->getContent()->shouldReturn($content);
    }

    function it_can_be_constructed_with_a_content()
    {
        $content = 'Contructor content';

        $this->beConstructedWith($content);

        $this->getContent()->shouldReturn($content);
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

    function it_should_have_an_array_of_parts()
    {
        $parts = array('aa', 'bb', 'cc');

        $this->setParts($parts);
        $this->getParts()->shouldReturn($parts);
    }

    function it_should_be_initialized_with_an_empty_set_of_parts()
    {
        $this->getParts()->shouldReturn(array());
    }

    function it_should_process_parts_from_content()
    {
        $this->beConstructedWith('ab#cd#ef');

        $this->getParts()->shouldReturn(array('ef' => 1, 'cd' => 1, 'ab' => 1));
    }

    function it_should_order_parts_by_occurence_count()
    {
        $this->beConstructedWith('ab#cd#ef#cd');

        $this->getParts()->shouldReturn(array('cd' => 2, 'ef' => 1, 'ab' => 1));
    }

    function it_should_only_keep_parts_that_have_more_than_one_character()
    {
        $this->beConstructedWith('ab#cd#e#cd');

        $this->getParts()->shouldReturn(array('cd' => 2, 'ab' => 1));
    }

    function it_should_have_a_pattern()
    {
        $pattern = 'simple_pattern';

        $this->setPattern($pattern);
        $this->getPattern()->shouldReturn($pattern);
    }

    function it_should_process_pattern_from_parts_and_separator()
    {
        $this->processPattern()->shouldReturn(null);

        $this->setParts(array('part1' => 2));
        $this->processPattern()->shouldReturn(null);

        $this->setSeparator('<separator>');

        $this->processPattern()->shouldReturn('/'.preg_quote('part1<separator>').'(.*)/');
    }

    function it_should_setup_pattern_from_content()
    {
        $this->beConstructedWith('ab#cd#ef#cd');

        $this->getPattern()->shouldReturn('/cd#(.*)/');
    }
}
