<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class Permissions
{
    /**
     * Config handler.
     */
    protected $config;

    /**
     * Apply constructor.
     *
     * @param $config
     * @param $state
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function fix(OutputInterface $output)
    {
        $vtigerDir = $this->config->getVtigerDir();

        $output->writeln("Fix permissions on: {$vtigerDir}");

        $commands = [
            "Fix user and group" => "chown -R www-data:www-data {$vtigerDir}",
            "Fix non writable files" => "cd {$vtigerDir}; find -type f -exec chmod 644 {} \;",
            "Fix non writable directories" => "cd {$vtigerDir}; find -type d -exec chmod 755 {} \;",
            "Fix non recursive writable files and directories" => "cd {$vtigerDir}; chmod 777 tabdata.php config.inc.php parent_tabdata.php modules",
            "Fix recursive writable files and directories" => "cd {$vtigerDir}; chmod 777 -R modules/Settings layouts/vlayout/modules storage user_privileges cron/modules test logs languages cache",
            "Fix executable files" => "cd {$vtigerDir}; chmod +x cron/vtigercron.sh && true",
            "Fix vtiger 7 writable items" => "cd {$vtigerDir}; chmod 777 -R layouts/v7/modules && true",
        ];

        foreach ($commands as $label => $command) {
            $output->writeln(' - '.$label);
            echo system($command);
        }

        return 1;
    }
}
