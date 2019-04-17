<?php

namespace Javanile\VtigerCli;

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use PDO;

class Database
{
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

        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        return $this->database;
    }
}
