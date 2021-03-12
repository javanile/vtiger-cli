<?php

namespace Javanile\VtigerCli\Tests;

use Symfony\Component\Console\Output\NullOutput;
use PHPUnit\Framework\TestCase;
use Javanile\VtigerCli\App;
use Javanile\MysqlImport\MysqlImport;

class DatabaseTest extends TestCase
{
    public function testInfo()
    {
        $app = new App(__DIR__.'/fixtures');
        $fake = new FakeOutput();
        $app->info($fake);

        var_dump($fake->getOutput());

        $this->assertEquals(
            "vtiger-cli 0.0.1\n".
            "  config file: /app/tests/fixtures/vtiger.json\n".
            "  vtiger directory: /var/www/html\n".
            "  working directory: /app/tests/fixtures\n",
            $fake->getOutput()
        );
    }
}
