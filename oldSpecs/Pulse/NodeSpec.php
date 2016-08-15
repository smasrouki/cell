<?php

namespace spec\Component\Pulse;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Component\Pulse\Pattern\Adapter\AdapterInterface;

class NodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Pulse\Node');
        $this->shouldImplement('Component\Pulse\Pattern\Adapter\AdaptedInterface');
    }

    function it_should_have_a_value()
    {
        $this->getValue()->shouldReturn('Node');

        $value = 'random value';

        $this->setValue($value);
        $this->getValue()->shouldReturn($value);
    }

    function it_should_return_its_value_when_processed()
    {
        $this->process()->shouldReturn('Node');
    }

    function it_has_an_adapter(AdapterInterface $adapter)
    {
        $this->setAdapter($adapter);
        $this->getAdapter()->shouldImplement('Component\Pulse\Pattern\Adapter\AdapterInterface');
    }

    function it_should_call_the_adapter_when_processed(AdapterInterface $adapter)
    {
        $this->setAdapter($adapter);
        $adapter->adapt('Node')->shouldBeCalled();

        $this->process();
    }
}
