<?php

namespace Javanile\VtigerCli;

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use PDO;

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
     */
    public function loadConfig(OutputInterface $output)
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
    public function saveConfig(OutputInterface $outout)
    {
        return file_put_contents(
            $this->configFile,
            json_encode(
                $this->config,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );
    }
}
