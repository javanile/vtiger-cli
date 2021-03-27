<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Console
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Config constructor.
     *
     * @param $workingDir
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     *
     */
    public function exec()
    {
        return passthru('php -f '.$this->config->getVtigerDir().'/vtlib/tools/console.php');
    }
}
