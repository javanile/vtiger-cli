<?php

namespace Javanile\VtigerCli\Tests;

use Symfony\Component\Console\Output\NullOutput;
use PHPUnit\Framework\TestCase;
use Javanile\VtigerCli\App;
use Javanile\MysqlImport\MysqlImport;
use Javanile\VtigerCli\Tests\Fixtures\MyClass;
use PDO;

class EntityMethodTest extends TestCase
{
    protected $app;

    protected $pdo;

    public function setUp()
    {
        $this->app = new App(__DIR__.'/fixtures');
        $this->pdo = Functions::import('/usr/src/vtiger/vtiger.sql');
        if (file_exists(__DIR__.'/fixtures/vtiger.lock')) {
            unlink(__DIR__.'/fixtures/vtiger.lock');
        }
    }

    public function testAddEntityMethodOnDatabase()
    {
        $method = MyClass::class.'::myMethod';
        $this->app->addEntityMethod('Contacts', $method);

        $sql = "SELECT * FROM com_vtiger_workflowtasks_entitymethod WHERE function_path='include/vtiger-cli/entrypoint.php'";
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($method, $row['method_name']);
    }

    public function testAddEntityMethodOnRuntime()
    {
        $method = MyClass::class.'::myMethod';
        $this->app->addEntityMethod('Contacts', $method);
        $lastname = md5(time().rand(0, 10000));

        Functions::createWorkflow();
        Functions::createContact($lastname);

        $this->assertFileExists(__DIR__.'/fixtures/tmp/'.$lastname);
    }
}
