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
    protected $configFile;

    /**
     * Config constructor.
     * @param $cwd
     */
    public function __construct($cwd)
    {
        $this->configFile = $this->cwd . '/vtiger.json';
    }

    /**
     * @param $output
     */
    public function loadConfig($io)
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
    public function saveConfig($io)
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
