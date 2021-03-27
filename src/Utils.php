<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;
use PDO;

class Utils
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
    public function __construct($config, $database)
    {
        $this->config = $config;
        $this->database = $database;
        //$this->state = $state;
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     *
     * @return bool
     */
    public function setPassword($username, $password, OutputInterface $output)
    {
        if (!$this->database->loadDatabase($output)) {
            return;
        }

        $sql = "SELECT id, user_name, crypt_type FROM vtiger_users WHERE status = 'Active' AND user_name = '{$username}' LIMIT 1";
        $row = $this->database->fetchRow($sql);

        $userId = $row['id'];
        $cryptType = $row['crypt_type'];

        $userPassword = $this->encryptPassword($username, $password, $cryptType);

        $sql = "UPDATE vtiger_users SET user_password = '{$userPassword}', confirm_password = '{$userPassword}' WHERE id = '{$userId}'";

        $this->database->exec($sql);
    }

    /**
     * Add EntityMethod on vtiger database.
     *
     * @param $module
     * @param $callable
     * @param OutputInterface $output
     * @return bool
     */
    public function getAccessKey($username, OutputInterface $output)
    {
        if (!$this->database->loadDatabase($output)) {
            return;
        }

        $sql = "SELECT accesskey FROM vtiger_users WHERE status = 'Active' AND user_name = '{$username}' LIMIT 1";
        $row = $this->database->fetchRow($sql);

        return $row['accesskey'];
    }

    /**
     * @param $username
     * @param $password
     * @param string $cryptType
     * @return string
     */
    function encryptPassword($username, $password, $cryptType = '')
    {
        $salt = substr($username, 0, 2);

        if ($cryptType == '') {
            $cryptType = 'MD5';
        }

        if ($cryptType == 'MD5') {
            $salt = '$1$' . $salt . '$';
        } elseif ($cryptType == 'BLOWFISH') {
            $salt = '$2$' . $salt . '$';
        } elseif ($cryptType == 'PHP5.3MD5') {
            $salt = '$1$' . str_pad($salt, 9, '0');
        }

        return crypt($password, $salt);
    }
}
