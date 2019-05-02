<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class Apply
{
    /**
     * Config handler.
     */
    protected $config;

    /**
     * Database handler.
     */
    protected $database;

    /**
     * State handler.
     */
    protected $state;

    /**
     * Apply constructor.
     *
     * @param $config
     * @param $state
     */
    public function __construct($config, $state)
    {
        $this->config = $config;
        $this->state = $state;
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function apply($callable, OutputInterface $output)
    {
        // state to check
        $state = ["apply|{$callable}" => 'once'];

        if (!$this->config->loadVtigerDir($output)) {
            return;
        }

        $this->state->loadState($output);
        if (!$this->state->checkState($state)) {
            return $output->info("[SKIP] ");
        }

        $this->state->merge($state);
        $this->state->saveState($output);

        $this->config->merge(['apply' => [$callable => 'once']]);
        $this->config->saveConfig($output);

        return true;
    }

    /**
     *
     */
    public function credits()
    {

    }
}
