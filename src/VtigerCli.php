<?php

namespace Javanile\VtigerCli;

use Silly\Application;
use Symfony\Component\Console\Output\OutputInterface;

class VtigerCli extends Application
{
    public function __construct()
    {
        parent::__construct('vtiger-cli', 'v0.0.1');
    }

    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function addEntityMethod($module, $callable, OutputInterface $output)
    {
        if (!$this->requireConfig()) {
            return;
        }

        $method = $callable;

        require_once 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
        $emm = new VTEntityMethodManager($adb);
        $emm->addEntityMethod($module, $method, 'extends/autoload.php', 'vtiger_extends_capture_action');
        vtiger_extends_save_json($json);
    }

    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function install($name, $yell, OutputInterface $output)
    {
        if ($name) {
            $text = 'Hello, '.$name;
        } else {
            $text = 'Hello';
        }

        if ($yell) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }

    /**
     *
     * @param $name
     * @param $yell
     * @param OutputInterface $output
     */
    public function apply($name, $yell, OutputInterface $output) {
        if ($name) {
            $text = 'Hello, '.$name;
        } else {
            $text = 'Hello';
        }

        if ($yell) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }

}
