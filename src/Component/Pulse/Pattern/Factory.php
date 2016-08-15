<?php

namespace Component\Pulse\Pattern;

use Component\Pulse\Pattern\Adapter\AdaptedInterface;

class Factory implements AdaptedInterface
{
    protected static $instance;

    protected $baseNamespace;

    private function __construct()
    {
        $this->baseNamespace = 'Component\Pulse\Pool';
    }

    public static function getInstance()
    {
    	if(self::$instance === null) {
            self::$instance = new Factory();
        }

        return self::$instance;
    }

    public function setBaseNamespace($baseNamespace)
    {
        $this->baseNamespace = $baseNamespace;
    }

    public function getBaseNamespace()
    {
        return $this->baseNamespace;
    }

    protected function getClassName($className)
    {
        return $this->baseNamespace.'\\'.$className;
    }

    public function create($className)
    {
        if($this->check($className) === false) {
            $this->generate($className);
        }

        $reflectionClass = new \ReflectionClass($this->getClassName($className));

        return $reflectionClass->newInstance();
    }

    public function check($className)
    {
        return class_exists($this->getClassName($className));
    }

    protected function generate($className)
    {
        $content = file_get_contents(__DIR__.'/Template/Class.tpl', 'w+');

        $content = str_replace('%className%', $className, $content);
        $content = str_replace('%baseNamespace%', $this->baseNamespace, $content);

        file_put_contents(__DIR__.'/../Pool/'.$className.'.php', $content);

        include __DIR__.'/../Pool/'.$className.'.php';
    }

    public function process($value = null)
    {
        if($value) {
            return $this->create($value);
        }
    }


}
