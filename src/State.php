<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class State
{
    /**
     *
     */
    protected $state;

    /**
     *
     */
    protected $stateFile;

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

        $path = pathinfo($this->config->getConfigFile());
        $this->stateFile = $path['dirname'].'/'.$path['filename'].'.lock';
    }

    /**
     * Initialize the state.
     *
     * @param OutputInterface $output
     * @return bool|int|void
     */
    public function init(OutputInterface $output)
    {
        $output->info('Init state');

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

    /**
     * Loading state file.
     */
    public function loadState(OutputInterface $output)
    {
        $this->state = [];
        $output->info('loading state');

        if (file_exists($this->stateFile)) {

        }
    }

    /**
     *
     */
    public function checkState($state)
    {
        foreach ($state as $stateKey => $stateValue) {
            if (isset($this->state[$stateKey])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Merge new state on current.
     *
     * @param $state
     */
    public function merge($state)
    {
        $this->state = array_replace_recursive($this->state, $state);
    }

    /**
     * Save current state on file.
     *
     * @param OutputInterface $output
     * @return bool|int
     */
    public function saveState(OutputInterface $output)
    {
        $output->info('update state file');

        $state = json_encode(
            $this->state,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );

        if (!$state || $state == 'null') {
            return $output->error("Can't save corrupted state.");
        }

        return file_put_contents($this->stateFile, $state);
    }
}
