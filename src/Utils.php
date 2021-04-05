<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;
use PDO;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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
     * State handler.
     */
    protected $interactive;

    /**
     * State handler.
     */
    protected $input;

    /**
     * State handler.
     */
    protected $output;

    /**
     * Apply constructor.
     *
     * @param $config
     * @param $state
     */
    public function __construct($config, $database, $interactive, $input, $output)
    {
        $this->config = $config;
        $this->database = $database;
        $this->interactive = $interactive;
        $this->input = $input;
        $this->output = $output;
        //$this->state = $state;
    }

    /**
     *
     */
    public function init()
    {
        if ($this->config->hasConfigFile()) {
            if (!$this->confirm("File 'vtiger.json' already exists, did you want update it? ")) {
                return;
            }
        }

        $position = $this->choice(
            'Where is placed your CRM?',
            ['Local: Installed on this machine', 'Remote: installed into a remote server']
        );

        $this->output->writeln('Looking for '.$position.'...');

        if ($position[0] == 'L') {
            $this->ask('In which directory is the CRM located? ');
        } else {
            $this->ask('In which URL is the CRM located? ');
        }
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

    /**
     *
     */
    public function confirm($message)
    {
        $question = new ConfirmationQuestion($message);

        return $this->interactive->ask($this->input, $this->output, $question);
    }

    /**
     *
     */
    public function choice($message, $options)
    {
        $question = new ChoiceQuestion($message, $options, 0);
        $question->setErrorMessage('Response %s is invalid.');

        return $this->interactive->ask($this->input, $this->output, $question);
    }

    /**
     *
     */
    public function ask($message)
    {
        $question = new Question($message);
        //$question->setErrorMessage('Response %s is invalid.');

        return $this->interactive->ask($this->input, $this->output, $question);
    }
}
