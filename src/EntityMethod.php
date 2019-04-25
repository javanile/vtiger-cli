<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class EntityMethod
{
    /**
     * Config handler.
     */
    protected $config;

    /**
     * Database handler.
     */
    protected $database;

    /**
     * State handler.
     */
    protected $state;

    /**
     * EntityMethod constructor.
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function add($module, $callable, OutputInterface $output)
    {
        // @vtiger({
        global $adb, $log, $dbconfigoption, $dbconfig;
        // });

        $this->config->loadVtigerDir($output);
        $method = $callable;

        // @vtiger({
        require_once 'include/utils/utils.php';
        error_reporting(E_ALL); ini_set('display_errors', 1); // fix logging because config.inc.php apply vtiger runtime logging
        require_once 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
        $emm = new \VTEntityMethodManager($adb);
        $emm->addEntityMethod($module, $method, 'extends/autoload.php', 'vtiger_extends_capture_action');
        // });

        $this->config->merge(['entity_method' => [$module => [$callable => 'once']]]);

        $this->config->saveConfig($output);
    }

    /**
     * @param $entity
     */
    public function logger($entity)
    {
        file_put_contents('vtiger.log', "logger\n", FILE_APPEND);
    }
}
