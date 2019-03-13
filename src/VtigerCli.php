<?php

namespace Javanile\VtigerCli;

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;
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
        $this->configFile = $this->cwd . '/vtiger.json';
    }

    /**
     * @param $output
     */
    private function loadConfig($io)
    {
        if (!file_exists($this->configFile)) {
            return;
        }

        $this->config = json_decode(file_get_contents($this->configFile), true);

        return $this->config;
    }

    /**
     * @return bool|int
     */
    private function saveConfig($io)
    {
        return file_put_contents(
            $this->configFile,
            json_encode(
                $this->config,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );
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

    /**
     * @param OutputInterface $output
     * @return PDO
     */
    public function loadDatabase(OutputInterface $io)
    {
        if ($this->database !== null) {
            return $this->database;
        }

        $inc = $this->loadVtigerConfigInc($io);

        $port = isset($inc['dbconfig']['db_port']) && strlen($inc['dbconfig']['db_port']) > 1
              ? substr($inc['dbconfig']['db_port'], 1) : '3306';

        $dsn = 'mysql:dbname='.$inc['dbconfig']['db_name'].';'
             . 'host='.$inc['dbconfig']['db_server'].';'
             . 'port='.$port;

        $this->database = new PDO($dsn, $inc['dbconfig']['db_username'], $inc['dbconfig']['db_password']);

        return $this->database;
    }
}
