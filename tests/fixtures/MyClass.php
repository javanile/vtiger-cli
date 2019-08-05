<?php

namespace Javanile\VtigerCli\Tests\Fixtures;

class MyClass
{
    public function myMethod($entity)
    {
        file_put_contents(__DIR__.'/tmp/'.$entity->get('lastname'), print_r($entity, true));
    }
}
