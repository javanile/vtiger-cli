<?php

namespace Javanile\VtigerCli;

use Symfony\Component\Console\Output\OutputInterface;
use Silly\Application;

class VtigerCli extends Application
{




    public function greet($name, $yell, OutputInterface $output) {
        if ($name) {
            $text = 'Hello, '.$name;
        } else {
            $text = 'Hello';
        }

        if ($yell) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }

}