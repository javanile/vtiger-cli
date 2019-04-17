<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;
use PDO;

class Database
{
    /**
     * @var
     */
    protected $config;

    /**
     *
     */
    protected $database;

    /**
     * Database constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param OutputInterface $output
     * @return PDO
     */
    public function loadDatabase(OutputInterface $output)
    {
        if ($this->database !== null) {
            return $this->database;
        }

        $inc = $this->config->loadVtigerConfigInc($output);
        if (!$inc) {
            return;
        }

        $port = isset($inc['dbconfig']['db_port']) && strlen($inc['dbconfig']['db_port']) > 1
            ? substr($inc['dbconfig']['db_port'], 1) : '3306';

        $dsn = 'mysql:dbname='.$inc['dbconfig']['db_name'].';'
            . 'host='.$inc['dbconfig']['db_server'].';'
            . 'port='.$port;

        $this->database = new PDO($dsn, $inc['dbconfig']['db_username'], $inc['dbconfig']['db_password']);

        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        return $this->database;
    }
}
