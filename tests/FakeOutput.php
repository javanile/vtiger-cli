<?php

namespace Javanile\VtigerCli\Tests;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

class FakeOutput implements OutputInterface
{
    protected $output;

    public function getOutput()
    {
        return $this->output;
    }

    public function write($messages, $newline = false, $options = 0)
    {

    }

    public function writeln($messages, $options = 0)
    {
        var_dump($messages);
        $this->output .= $messages."\n";
    }

    public function setVerbosity($level)
    {

    }

    public function getVerbosity()
    {
        return null;
    }

    public function isQuiet()
    {
        return false;
    }

    public function isVerbose()
    {
        return false;
    }

    public function isVeryVerbose()
    {
        return false;
    }

    public function isDebug()
    {
        return fasle;
    }

    public function setDecorated($decorated)
    {

    }

    public function isDecorated()
    {
        return false;
    }

    public function setFormatter(OutputFormatterInterface $formatter)
    {

    }

    public function getFormatter()
    {
        return null;
    }
}
