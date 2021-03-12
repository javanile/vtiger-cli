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
    public function __construct($config, $state)
    {
        $this->config = $config;
        $this->state = $state;
    }

    /**
     *
     */
    public function call($operation, $args, $output)
    {
        $client = new VtigerClient();

        if (method_exists($client, $operation)) {

        } else {

        }

        $response = call_user_func_array([$client, $operation], []);

        json_encode(, JSON_UNESCAPED_SLASHES);
        $output->write();

        return
    }
}
