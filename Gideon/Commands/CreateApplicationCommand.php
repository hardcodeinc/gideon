<?php

namespace Gideon\Commands;

use Gideon\Core\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CreateApplicationCommand extends Command
{
    protected function configure()
    {
        $this->setName('new')
             ->setDescription('Creates a application using starter package.')
             ->addArgument('destination', InputArgument::OPTIONAL, 'Project destination folder.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // destination folder of the application.
        $destination = $input->getArgument('destination') ?: 'gideon';

        $this->cloneTemplate($destination, $output);

        $this->installDependencies($destination, $output);
    }

    protected function installDependencies($destination, OutputInterface $output)
    {
        $installDependenciesCommand = $this->getApplication()
                                           ->find('install-dependencies');

        $installDependenciesArguments = [
            'command'     => 'install-dependencies',
            'destination' => $destination
        ];

        $installDependenciesCommand->run(new ArrayInput($installDependenciesArguments), $output);
    }

    protected function cloneTemplate($destination, OutputInterface $output)
    {
        $cloneCommand = $this->getApplication()
                             ->find('clone');

        $cloneArguments = [
            'command'     => 'clone',
            'destination' => $destination
        ];

        $cloneInput = new ArrayInput($cloneArguments);

        $cloneCommand->run($cloneInput, $output);
    }
}
