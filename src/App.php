<?php

namespace Javanile\VtigerCli;

use Javanile\VtigerClient\VtigerClient;
use Silly\Application as SillyApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class App
 *
 * @package Javanile\VtigerCli
 */
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
        parent::__construct('vtiger-cli', '0.2.0');

        $this->config = new Config($cwd);
        $this->database = new Database($this->config);
    }

    /**
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();

        $definition->addOption(new InputOption('site-url', 's', InputOption::VALUE_OPTIONAL, 'Set current site url'));
        $definition->addOption(new InputOption('username', 'u', InputOption::VALUE_OPTIONAL, 'Set current username'));
        $definition->addOption(new InputOption('password', 'p', InputOption::VALUE_OPTIONAL, 'Set current password'));
        $definition->addOption(new InputOption('access-key', 'a', InputOption::VALUE_OPTIONAL, 'Set current access key'));

        return $definition;
    }

    /**
     * Init and take control of CRM.
     *
     * @usage
     *
     * @param $operation
     * @param $args
     * @param OutputInterface $output
     *
     * @return integer
     */
    public function init(InputInterface $input, OutputInterface $output)
    {
        $interactive = $this->getHelperSet()->get('question');
        $utils = new Utils($this->config, $this->database, $interactive, $input, $output);

        return $utils->init();
    }

    /**
     * Get CRM instance information.
     *
     * @ignore
     * @usage vtiger info
     *
     * @param OutputInterface $output
     */
    public function info(InputInterface $input, OutputInterface $output)
    {
        $this->config->loadConfig($output);

        $output->writeln('==[ '.$this->getName().' '.$this->getVersion().' ]==');
        $output->writeln('Config file: '.$this->config->getConfigFile());
        $output->writeln('Vtiger directory: '.$this->config->getVtigerDir());
        $output->writeln('Working directory: '.$this->config->getWorkingDir());
        $output->writeln('Site URL: '.$this->config->getSiteUrl($input));
    }

    /**
     * @ignore
     * @usage
     * @param OutputInterface $output
     */
    public function install(OutputInterface $output)
    {
        if (!$this->config->loadConfig($output)) {
            return;
        }

        $state = new State($this->config, $this->database);

        if (!$state->init($output)) {
            $output->writeln('<fail>Installation fail</fail>');
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
     * @ignore
     * @usage
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
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     * @return integer
     */
    public function apply($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     * @return integer
     */
    public function setPassword($username, $password, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $utils = new Utils($this->config, $this->database, $state);

        return $utils->setPassword($username, $password, $output);
    }

    /**
     * Apply code execution to vtiger.
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     * @return integer
     */
    public function export($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     * @return integer
     */
    public function exportDatabase($file, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $import = new Import($this->config, $state);

        return $import->importDatabase($file, $output);
    }

    /**
     * Apply code execution to vtiger.
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     *
     * @return integer
     */
    public function exportStorage($callable, OutputInterface $output)
    {
        $state = new State($this->config, $this->database);
        $apply = new Apply($this->config, $state);

        return $apply->apply($callable, $output);
    }

    /**
     * Apply code execution to vtiger.
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     * @return integer
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
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     *
     * @return integer
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
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     * @return integer
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
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     *
     * @return integer
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
     * @ignore
     * @usage
     *
     * @param $callable
     * @param OutputInterface $output
     *
     * @return integer
     */
    public function console(OutputInterface $output)
    {
        $this->config->loadConfig($output);
        $this->config->loadVtigerDir($output);

        $console = new Console($this->config);

        return $console->exec();
    }

    /**
     * Apply code execution to vtiger.
     *
     * @ignore
     * @usage
     *
     * @param $operation
     * @param $args
     * @param OutputInterface $output
     *
     * @return integer
     */
    public function client($operation, $args, InputInterface $input, OutputInterface $output)
    {
        $this->config->loadConfig($output);
        $this->config->loadVtigerDir($output);

        $utils = new Utils($this->config, $this->database);
        $client = new Client($this->config, $utils);

        return $client->call($operation, $args, $input, $output);
    }

    /**
     * Apply code execution to vtiger.
     *
     * @ignore
     * @usage
     *
     * @param $operation
     * @param $args
     * @param OutputInterface $output
     *
     * @return integer
     */
    public function ping($operation, $args, InputInterface $input, OutputInterface $output)
    {
        $this->config->loadConfig($output);
        $this->config->loadVtigerDir($output);

        $utils = new Utils($this->config, $this->database);
        $client = new Client($this->config, $utils);

        return $client->call($operation, $args, $input, $output);
    }
}
