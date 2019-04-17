<?php

namespace Javanile\VtigerCli;

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use PDO;

class EntityMethod
{
    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function add($module, $callable, OutputInterface $io)
    {
        global $adb, $log, $dbconfigoption, $dbconfig;

        $this->loadVtigerDir($io);

        $method = $callable;

        require_once 'include/utils/utils.php';

        // fix logging because config.inc.php apply vtiger runtime logging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        require_once 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
        $emm = new \VTEntityMethodManager($adb);
        $emm->addEntityMethod($module, $method, 'extends/autoload.php', 'vtiger_extends_capture_action');
        $this->saveConfig($io);
    }
}