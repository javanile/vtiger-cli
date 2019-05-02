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
     *
     * @param $config
     * @param $state
     */
    public function __construct($config, $state)
    {
        $this->config = $config;
        $this->state = $state;
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function add($module, $callable, OutputInterface $output)
    {
        // @vtiger({
        global $adb, $log, $dbconfigoption, $dbconfig;
        // });

        if (!$this->config->loadVtigerDir($output)) {
            return;
        }

        $method = $callable;

        // @vtiger({
        require_once 'include/utils/utils.php';
        error_reporting(E_ALL); ini_set('display_errors', 1); // fix logging because config.inc.php apply vtiger runtime logging
        require_once 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
        $emm = new \VTEntityMethodManager($adb);
        $emm->addEntityMethod($module, $method, 'extends/autoload.php', 'vtiger_extends_capture_action');
        // });

        $state = ['entity_method' => [$module => [$callable => 'once']]];

        $this->state->merge($state);
        $this->state->saveState($output);

        $this->config->merge($state);
        $this->config->saveConfig($output);

        return true;
    }

    /**
     * @param $entity
     */
    public function logger($entity)
    {
        file_put_contents('vtiger.log', "logger\n", FILE_APPEND);
    }
}
