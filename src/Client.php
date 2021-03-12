<?php

namespace Javanile\VtigerCli;

use Javanile\VtigerClient\VtigerClient;
use Symfony\Component\Console\Input\InputInterface;
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
    protected $utils;

    /**
     * Apply constructor.
     *
     * @param $config
     * @param $state
     */
    public function __construct($config, $utils)
    {
        $this->config = $config;
        $this->utils = $utils;
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

        $username = $this->config->getUsername($input, $output);
        $accessKey = $this->getAccessKey($username, $input, $output);

        if ($accessKey) {
            $client->login($username, $accessKey);
        }

        $response = call_user_func_array([$client, $operation], $args);

        $payload = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $output->writeln($payload);

        return empty($response['success']) ? 1 : 0;
    }

    /**
     * @return string
     */
    public function getAccessKey($username, InputInterface $input, OutputInterface $output)
    {
        if ($accessKey = $input->getOption('access-key')) {
            return $accessKey;
        }

        if ($this->config->has('access_key')) {
            return $this->config->get('access_key');
        }

        return $this->utils->getAccessKey($username, $output);
    }
}
