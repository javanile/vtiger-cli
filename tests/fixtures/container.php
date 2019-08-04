<?php

use Psr\Container\ContainerInterface;
use Javanile\VtigerCli\Tests\Fixtures\MyClass;

class Container implements ContainerInterface
{
    protected $container;

    public function __construct()
    {
        $this->container = [
            MyClass::class => new MyClass,
        ];
    }

    public function get($id)
    {
        return $this->container[$id];
    }

    public function has($id)
    {
        return isset($this->container[$id]);
    }
}

return new Container();
