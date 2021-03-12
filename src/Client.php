<?php

namespace Javanile\VtigerCli;

use Javanile\VtigerClient\VtigerClient;
use Symfony\Component\Console\Output\OutputInterface;

class Client
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
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     *
     */
    public function call($operation, $args, $input, $output)
    {
        $siteUrl = $this->config->getSiteUrl($input, $output);
        if (empty($siteUrl)) {
            return $output->error("Missing site url");
        }

        $client = new VtigerClient($siteUrl);

        foreach ($args as &$arg) {
            if ($arg[0] == '{') {
                $arg = json_decode($arg, true);
            }
        }

        if (!method_exists($client, $operation)) {
            $output->error("Invalid operation: $operation");
            return 1;
        }

        $response = call_user_func_array([$client, $operation], $args);

        $payload = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $output->write($payload);

        return empty($response['success']) ? 1 : 0;
    }
}
