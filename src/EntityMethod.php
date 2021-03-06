<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class EntityMethod
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
     * EntityMethod constructor.
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
    public function add($module, $callable, OutputInterface $output)
    {
        // state to check
        $state = ["entity_method|{$module}|{$callable}" => 'once'];

        // @vtiger({
        global $adb, $log, $dbconfigoption, $dbconfig;
        // });

        if (!$this->config->loadVtigerDir($output)) {
            return;
        }

        $this->state->loadState($output);
        if (!$this->state->checkState($state)) {
            return $output->writeln("[SKIP] ");
        }

        $this->updateEntrypoint();

        $method = $callable;

        // @vtiger({
        require_once 'include/utils/utils.php';
        error_reporting(E_ALL); ini_set('display_errors', 1); // fix logging because config.inc.php apply vtiger runtime logging
        require_once 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
        $emm = new \VTEntityMethodManager($adb);
        $emm->addEntityMethod($module, $method, 'include/vtgier-cli/entrypoint.php', 'vtiger_cli_entrypoint_entity_method');
        // });

        $this->state->merge($state);
        $this->state->saveState($output);

        $this->config->merge(['entity_method' => [$module => [$callable => 'once']]]);
        $this->config->saveConfig($output);

        return true;
    }

    /**
     *
     */
    protected function updateEntrypoint()
    {
        $vtigerDir = $this->config->getVtigerDir();
        $vendorDir = $this->config->getVendorDir();
        $containerFile = $this->config->getContainerFile();
        if (!is_dir($vtigerDir.'/include/vtiger-cli/')) {
            mkdir($vtigerDir.'/include/vtiger-cli/', 0775, true);
        }
        file_put_contents(
            $vtigerDir.'/include/vtiger-cli/entrypoint.php',
            str_replace([
                '__VENDOR_DIR__',
                '__CONTAINER_FILE__',
            ], [
                "'{$vendorDir}'",
                "'{$containerFile}'",
            ], file_get_contents(__DIR__.'/../entrypoint.php'))
        );
    }

    /**
     * @param $entity
     */
    public function logger($entity)
    {
        file_put_contents('vtiger.log', "logger\n", FILE_APPEND);
    }
}
