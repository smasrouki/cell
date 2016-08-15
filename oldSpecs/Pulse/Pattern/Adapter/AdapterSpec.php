<?php

namespace spec\Component\Pulse\Pattern\Adapter;

use Component\Pulse\Pattern\Adapter\AdaptedInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AdapterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Pulse\Pattern\Adapter\Adapter');
        $this->shouldImplement('Component\Pulse\Pattern\Adapter\AdapterInterface');
    }

    function it_has_an_adapted(AdaptedInterface $adapted)
    {
        $this->setAdapted($adapted);
        $this->getAdapted()->shouldImplement('Component\Pulse\Pattern\Adapter\AdaptedInterface');
    }

    function it_should_process_the_adapted(AdaptedInterface $adapted)
    {
        $this->setAdapted($adapted);
        $value = 'Random value';
        $adapted->process($value)->shouldBeCalled();
        $adapted->process($value)->willReturn('ok');

        $this->adapt($value)->shouldReturn('ok');
    }
}
