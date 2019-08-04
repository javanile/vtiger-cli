<?php

namespace Javanile\VtigerCli\Tests;

use Symfony\Component\Console\Output\NullOutput;
use PHPUnit\Framework\TestCase;
use Javanile\VtigerCli\VtigerCli;
use Javanile\MysqlImport\MysqlImport;

class AppTest extends TestCase
{
    public function testVtigerConfigInc()
    {
        $app = new VtigerCli(getcwd());
        $this->assertEquals([
            "dbconfig" => [
                "db_server" => "mysql",
                "db_port" => ":3306",
                "db_username" => "root",
                "db_password" => "root",
                "db_name" => "vtiger",
                "db_type" => "mysqli",
                "db_status" => "true",
                "db_hostname" => "mysql:3306",
                "log_sql" => false
            ]
        ], $app->loadVtigerConfigInc(new NullOutput));
    }

    public function testAddEntityMethod()
    {
        $mysql = new MysqlImport($_ENV, ['/var/www/html/vtiger.sql']);
        $mysql->run();

        $app = new VtigerCli(getcwd());

        $app->addEntityMethod(
            'Contacts',
            '\\Javanile\\VtigerCli\\Tests\\Fixtures\\MyClass::myMethod',
            new NullOutput
        );

        $db = $app->loadDatabase(new NullOutput);

        $stmt = $db->query("SELECT * FROM com_vtiger_workflowtasks_entitymethod WHERE function_path='extends/autoload.php'");
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->assertEquals('\\Javanile\\VtigerCli\\Tests\\Fixtures\\MyClass::myMethod', $row['method_name']);
    }
}
