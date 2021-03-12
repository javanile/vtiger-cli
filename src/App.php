<?php

namespace Javanile\VtigerCli;

use Javanile\VtigerClient\VtigerClient;
use Silly\Application as SillyApplication;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;

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

        $state = new State($this->config, $this->database);

        if (!$state->init($output)) {
            $output->writeln('<fail>Installaion fail</fail>');
        }

        $apply = new Apply($this->config, $state);
        foreach ($this->config->getApply() as $callable => $mode) {
            $apply->apply($callable, $output);
        }

        $entityMethod = new EntityMethod($this->config, $state);
        foreach ($this->config->getEntityMethod() as $entityMethods) {
            foreach ($entityMethods as $module => $callable) {
                $entityMethod->add($module, $callable, $output);
            }
        }
    }

    /**
     * Add EntityMethod on vtiger database for triggering into workflow.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     */
    public function addEntityMethod($module, $callable, OutputInterface $output = null)
    {
        if ($output === null) {
            $output = new NullOutput();
        }

        $state = new State($this->config, $this->database);
        $entityMethod = new EntityMethod($this->config, $state);

        var_dump("call");

        return $entityMethod->add($module, $callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function apply($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function setPassword($username, $password, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $utils = new Utils($this->config, $this->database, $state);

        return $utils->setPassword($username, $password, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function export($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function exportDatabase($file, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $import = new Import($this->config, $state);

        $import->importDatabase($file, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function exportStorage($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function import($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function importDatabase($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function importStorage($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function permissions($fix, OutputInterface $output)
    {
        $this->config->loadConfig($output);
        $this->config->getVtigerDir();

        $permissions = new Permissions($this->config);

        if ($fix) {
            $permissions->fix($output);
        }

        return true;
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $callable
     * @param OutputInterface $output
     * @return
     */
    public function console(OutputInterface $output)
    {
        $this->config->loadConfig($output);
        $this->config->loadVtigerDir($output);

        return passthru('php -f '.$this->config->getVtigerDir().'/vtlib/tools/console.php');
    }

    /**
     * Apply code execution to vtiger.
     *
     * @param $operation
     * @param $args
     * @param OutputInterface $output
     *
     * @return void
     */
    public function client($operation, $args, OutputInterface $output)
    {
        $this->config->loadConfig($output);
        $this->config->loadVtigerDir($output);

        $client = new Client($this->config);

        return $client->call($operation, $args, $output);
    }
}
