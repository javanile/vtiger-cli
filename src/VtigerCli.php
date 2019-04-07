<?php

namespace Javanile\VtigerCli;

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use PDO;

class VtigerCli extends Application
{
    /**
     *
     */
    protected $config;

    /**
     *
     */
    protected $vtigerDir;

    /**
     *
     */
    protected $state;

    /**
     *
     */
    protected $database;

    /**
     *
     */
    protected $vtigerConfigInc;

    /**
     *
     */
    protected $vtigerConfigIncPath;

    /**
     * VtigerCli constructor.
     * @param string $cwd
     */
    public function __construct($cwd)
    {
        parent::__construct('vtiger-cli', 'v0.0.1');

        $this->cwd = $cwd;
        $this->config = new Config($this->cwd);
        $this->database = new Database();
    }

    /**
     * VtigerCli constructor.
     * @param string $cwd
     */
    public function info(OutputInterface $io)
    {

    }

    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function addEntityMethod($module, $callable, OutputInterface $io)
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

    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function install(OutputInterface $io)
    {
        if (!$this->requireConfig($output)) {
            return;
        }
    }

    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function apply($callable, OutputInterface $io)
    {
    }

    /**
     * @param $io
     * @return array
     */
    public function loadVtigerConfigInc($io)
    {
        if ($this->vtigerConfigInc !== null) {
            return $this->vtigerConfigInc;
        }

        $this->loadVtigerDir($io);

        $this->vtigerConfigIncPath = $this->vtigerDir . '/config.inc.php';

        include $this->vtigerConfigIncPath;

        // fix logging because config.inc.php apply vtiger runtime logging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $this->vtigerConfigInc = [
            'dbconfig' => $dbconfig,
        ];

        return $this->vtigerConfigInc;
    }

    /**
     * @param OutputInterface $output
     * @return PDO
     */
    public function loadVtigerDir(OutputInterface $io)
    {
        if ($this->vtigerDir !== null) {
            return $this->vtigerDir;
        }

        $this->loadConfig($io);

        $this->vtigerDir = $this->config['vtiger_dir'];

        set_include_path($this->vtigerDir);

        return $this->vtigerDir;
    }


}
