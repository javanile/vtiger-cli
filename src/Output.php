<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class Output extends ConsoleOutput
{
    /**
     * Output constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->getFormatter()->setStyle('error', new OutputFormatterStyle('red', 'default'));
        $this->getFormatter()->setStyle('info', new OutputFormatterStyle('yellow', 'default'));
        $this->getFormatter()->setStyle('success', new OutputFormatterStyle('green', 'default'));
    }

    /**
     *
     */
    public function info($message)
    {
        $this->getErrorOutput()->writeln($message);
    }

    /**
     *
     */
    public function error($message)
    {
        return $this->getErrorOutput()->writeln("<error>{$message}</error>");
    }
}
