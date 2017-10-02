<?php

namespace Gideon\Commands;

use Gideon\Core\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CreateApplicationCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new')
            ->setDescription('Creates a application using starter package.')
            ->addArgument(
                'destination',
                InputArgument::OPTIONAL,
                'Project destination folder.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // destination folder of the application.
        $destination = $input->getArgument('destination') ?: 'gideon';

        // clone the template repository.
        $output->writeln('Cloning template repository, please wait...');
        $this->executeExternalCommand(sprintf('git clone https://github.com/julianobailao/laravel-module %s', $destination), $output);

        // install dependencies.
        $afterCloneCommands = [
            sprintf('cd %s', $destination),
            'composer install',
            'mv .env.example .env',
            'php artisan key:generate',
            'rm -rf .git',
            'php artisan inspire',
        ];
        $output->writeln('Application created, instaling dependencies, please wait...');
        $this->executeExternalCommand(implode(' && ', $afterCloneCommands), $output);
    }
}
