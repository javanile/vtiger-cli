<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;

class ImportExport
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
    public function import($file, OutputInterface $output)
    {
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($type) {
            case 'sql':
                $output->info("Import SQL: {$file}");
                break;
        }
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function importDatabase($file, OutputInterface $output)
    {
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($type) {
            case 'sql':
                $output->info("Import SQL: {$file}");
                break;
        }
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function importStorage($file, OutputInterface $output)
    {
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($type) {
            case 'zip':
                $output->info("Import SQL: {$file}");
                break;

            case 'tar':
                $output->info("Import SQL: {$file}");
                break;

            case 'tar.gz':
                $output->info("Import SQL: {$file}");
                break;
        }
    }

    /**
     *
     */
    public function credits()
    {

    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function export($file, OutputInterface $output)
    {
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($type) {
            case 'sql':
                $output->info("Import SQL: {$file}");
                break;
        }
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function exportDatabase($file, OutputInterface $output)
    {
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($type) {
            case 'sql':
                $output->info("Import SQL: {$file}");
                break;
        }
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function exportStorage($file, OutputInterface $output)
    {
        $type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        switch ($type) {
            case 'zip':
                $output->info("Import SQL: {$file}");
                break;

            case 'tar':
                $output->info("Import SQL: {$file}");
                break;

            case 'tar.gz':
                $output->info("Import SQL: {$file}");
                break;
        }
    }
}
