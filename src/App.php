<?php

namespace Javanile\VtigerCli;

use Silly\Application as SillyApplication;
use Symfony\Component\Console\Output\OutputInterface;

class App extends SillyApplication
{
    /**
     * Configuration handler.
     */
    protected $config;

    /**
     * Database handler.
     */
    protected $database;

    /**
     * VtigerCli constructor.
     *
     * @param string $cwd
     */
    public function __construct($cwd)
    {
        parent::__construct('vtiger-cli', '0.0.1');

        $this->config = new Config($cwd);
        $this->database = new Database($this->config);
    }

    /**
     * @param OutputInterface $output
     */
    public function info(OutputInterface $output)
    {
        $this->config->loadConfig($output);
        $output->writeln($this->getName().' ('.$this->getVersion().')');
        $output->writeln('  config file: '.$this->config->getConfigFile());
        $output->writeln('  vtiger directory: '.$this->config->getVtigerDir());
        $output->writeln('  working directory: '.$this->config->getWorkingDir());
    }

    /**
     * @param OutputInterface $output
     */
    public function install(OutputInterface $output)
    {
        if (!$this->config->loadConfig($output)) {
            return;
        }

        $state = new State($this->config, $database);

        if (!$state->install($output)) {
            $output->writeln('<fail>Installaion fail</fail>');
        }
    }

    /**
     * Add EntityMethod on vtiger database for triggering into workflow.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     */
    public function addEntityMethod($module, $callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $entityMethod = new EntityMethod($this->config, $state);

        return $entityMethod->add($module, $callable, $output);
    }

    /**
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     */
    public function apply($module, $callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $entityMethod = new EntityMethod($this->config, $state);

        return $entityMethod->add($module, $callable, $output);
    }
}
