<?php

namespace Gideon\Core;

use Gideon\Util\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandWithConfig extends Command
{
    protected $config;

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->config = Configuration::loadFile();

        return parent::run($input, $output);
    }
}
