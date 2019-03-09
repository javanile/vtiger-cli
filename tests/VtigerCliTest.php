<?php

namespace Javanile\VtigerCli\Tests;

use Symfony\Component\Console\Output\NullOutput;
use PHPUnit\Framework\TestCase;
use Javanile\VtigerCli\VtigerCli;

class VtigerCliTest extends TestCase
{
    public function testAddEntityMethod()
    {
        $app = new VtigerCli();
        $app->addEntityMethod(
            'Contacts',
            '\\Javanile\\VtigerCli\\Tests\\Fixtures\\MyClass::myMethod',
            new NullOutput
        );
    }
}
