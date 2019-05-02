<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class Config
{
    /**
     * @var string
     */
    protected $workingDir;

    /**
     * @var string
     */
    protected $configFile;

    /**
     * @var array
     */
    protected $config;

    /**
     *
     */
    protected $vtigerDir;

    /**
     * @var
     */
    protected $vtigerConfigIncFile;

    /**
     *
     */
    protected $vtigerConfigInc;

    /**
     * Config constructor.
     *
     * @param $workingDir
     */
    public function __construct($workingDir)
    {
        $this->workingDir = realpath($workingDir);
        $this->configFile = $workingDir . '/vtiger.json';
    }

    /**
     * @return string
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * @return string
     */
    public function getVtigerDir()
    {
        return $this->config['vtiger_dir'];
    }

    /**
     * @return string
     */
    public function getWorkingDir()
    {
        return $this->workingDir;
    }

    /**
     * @param $output
     * @return array|mixed
     */
    public function loadConfig(OutputInterface $output)
    {
        if (!file_exists($this->configFile)) {
            return $output->error("Config file '{$this->configFile}' not found.");
        }

        $this->config = json_decode(file_get_contents($this->configFile), true);

        if (!is_array($this->config)) {
            return $output->error("Config file '{$this->configFile}' is empty or corrupted.");
        }

        return $this->config;
    }

    /**
     * @param $io
     * @return array
     */
    public function loadVtigerConfigInc($output)
    {
        if ($this->vtigerConfigInc !== null) {
            return $this->vtigerConfigInc;
        }

        $this->loadVtigerDir($output);

        $this->vtigerConfigIncFile = $this->vtigerDir . '/config.inc.php';

        include $this->vtigerConfigIncFile;

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
    public function loadVtigerDir(OutputInterface $output)
    {
        if ($this->vtigerDir !== null) {
            return $this->vtigerDir;
        }

        if (!$this->loadConfig($output)) {
            return '';
        }

        $this->vtigerDir = $this->config['vtiger_dir'];

        $output->info("load vtiger directory: $this->vtigerDir");

        set_include_path($this->vtigerDir);

        return $this->vtigerDir;
    }

    /**
     * Merge additional config on current config.
     *
     * @param $config
     */
    public function merge($config)
    {
        $this->config = array_replace_recursive($this->config, $config);
    }

    /**
     * Save config file.
     *
     * @param OutputInterface $output
     * @return bool|int
     */
    public function saveConfig(OutputInterface $output)
    {
        $output->info('update config file');

        return file_put_contents(
            $this->configFile,
            json_encode(
                $this->config,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );
    }
}
