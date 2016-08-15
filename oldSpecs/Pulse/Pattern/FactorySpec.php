<?php

namespace spec\Component\Pulse\Pattern;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FactorySpec extends ObjectBehavior
{
    function let()
    {
    	$this->beConstructedThrough('getInstance');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Component\Pulse\Pattern\Factory');
    }

    function it_should_initialize_its_base_namespace()
    {
        $this->getBaseNamespace()->shouldReturn('Component\Pulse\Pool');
    }

    function it_have_a_base_namespace()
    {
        $baseNamespace = 'Component\Pulse\Any';

        $this->setBaseNamespace($baseNamespace);
        $this->getBaseNamespace()->shouldReturn($baseNamespace);
    }

    function it_should_create_objects_by_class_name()
    {
    	$className = 'TestClass';
        $baseNamespace = 'Component\Pulse\Test';
        $this->setBaseNamespace($baseNamespace);

	    $this->create($className)->shouldHaveType('Component\Pulse\Test\TestClass');
    }

    function it_should_generate_the_object_class_if_it_doesnt_exist()
    {
        $className = 'DoesntExist';

        $this->check($className)->shouldReturn(false);

        $this->create($className)->shouldHaveType('Component\Pulse\Pool\DoesntExist');
    }

    function letGo()
    {
        $testClass = __DIR__.'/../../../../src/Component/Pulse/Pool/DoesntExist.php';

        if(file_exists($testClass)) {
            unlink($testClass);
        }

        $this->setBaseNamespace('Component\Pulse\Pool');
    }
}
