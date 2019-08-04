<?php

namespace Javanile\VtigerCli\Tests;

use Javanile\MysqlImport\MysqlImport;
use Javanile\HttpRobot\HttpRobot;
use PDO;

class Functions
{
    public static function import($file)
    {
        $mysqlHost = getenv('MYSQL_HOST') ?: 'mysql';
        $mysqlDatabase = getenv('MYSQL_DATABASE') ?: 'vtiger';
        $mysqlRootPassword = getenv('MYSQL_ROOT_PASSWORD');

        $db = new PDO("mysql:host={$mysqlHost};dbname={$mysqlDatabase}", 'root', $mysqlRootPassword);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->query("DROP DATABASE IF EXISTS `{$mysqlDatabase}`");

        $mysqlImport = new MysqlImport($_ENV, [$file]);
        $mysqlImport->run();

        $db->query("USE `{$mysqlDatabase}`");

        return $db;
    }

    public static function createRobot()
    {
        $robot = new HttpRobot(['base_uri' => 'http://vtiger/', 'cookies'  => true]);
        $vtrftk = $robot->get('index.php', '__vtrftk');

        $text = $robot->post(
            'index.php?module=Users&action=Login',
            [
                '__vtrftk' => $vtrftk,
                'username' => 'admin',
                'password' => 'admin',
            ],
            ['@text']
        );

        return $robot;
    }

    public static function createWorkflow()
    {
        $robot = static::createRobot();
        $vtrftk = $robot->get('index.php?module=Workflows&parent=Settings&view=Edit&mode=V7Edit', '__vtrftk');

        $text = $robot->post('index.php', [
            '__vtrftk' => $vtrftk,
            'record' => '',
            'module' => 'Workflows',
            'action' => 'SaveWorkflow',
            'parent' => 'Settings',
            'returnsourcemodule' => '',
            'returnpage' => '',
            'returnsearch_value' => '',
            'workflowname' => 'Sample Workflow from test',
            'summary' => '',
            'module_name' => 'Contacts',
            'status' => 'active',
            'workflow_trigger' => 3,
            'workflow_trigger' => 1,
            'workflow_recurrence' => 3,
            'schtypeid' => 1,
            'schdayofweek' => '',
            'schdate' => '',
            'schtime' => '',
            'conditions' => '{}',
            'filtersavedinnew' => 6,
            'date_filters' => '',
            'advanceFilterOpsByFieldType' => '',
            'advanceFilterOptions' => '',
            'columnname' => 'none',
            'comparator' => 'none',
            'column_condition' => 'and',
            'condition' => 'and',
            'columnname' => 'none',
            'comparator' => 'none',
            'column_condition' => 'or',
            'tasks[]' => json_encode((object) [
                "__vtrftk" => $vtrftk,
                "module" => "Workflows",
                "parent" => "Settings",
                "action" => "TaskAjax",
                "mode" => "Save",
                "for_workflow" => "",
                "task_id" => "",
                "taskType" => "VTEntityMethodTask",
                "tmpTaskId" => "11974161356406",
                "summary" => "MyMethod",
                "methodName" => "Javanile\\VtigerCli\\Tests\\Fixtures\\MyClass::myMethod"
            ]),
        ], '@text');
    }
}
