<?php

namespace spec\Component\Cell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CellSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Cell\Cell');
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
}
