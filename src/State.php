<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class State
{
    /**
     *
     */
    protected $config;

    /**
     *
     */
    protected $database;

    /**
     * State constructor.
     *
     * @param $config
     * @param $database
     */
    public function __construct($config, $database)
    {
        $this->config = $config;
        $this->database = $database;
    }

    /**
     *
     */
    public function install()
    {
        $db = $this->database->loadDatabase();
        if ($db) {
            return;
        }

        $db->exec(
            "CREATE TABLE IF NOT EXISTS `vtiger_cli` (                   
                `state_key` varchar(255) NOT NULL default '',       
                `state_value` varchar(255) NOT NULL default ''     
            );"
        );

        $entrypoint = '<?php ';

        return file_put_contents($this->config->getEntrypoint(), $entrypoint);
    }
}