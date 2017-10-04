<?php
/**
 * Created by PhpStorm.
 * User: Carlos Fiori
 * Date: 03/10/2017
 * Time: 19:18
 */

namespace Gideon\Commands;


use Gideon\Core\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallDependenciesCommand extends Command
{
    protected function configure()
    {
        $this->setName('install-dependencies')
             ->setDescription("Install dependencies for project")
             ->addArgument('destination', InputArgument::REQUIRED, 'Project destination folder');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Installing dependencies, please wait...');
        $destination = $input->getArgument('destination') ?: 'gideon';

        $this->executeExternalCommand(sprintf('cd %s', $destination), $output);

        $fileCommands = [
            'composer.json' => 'installComposerDependencies',
            'artisan'       => 'installLaravelDependencies',
        ];
        //        $this->executeExternalCommand('pwd', $output);

        foreach ($fileCommands as $file => $command) {
            if (file_exists($file)) {
                $this->$command($output);
            }
        }
    }

    protected function installComposerDependencies(OutputInterface $output)
    {
        $output->writeln('Installing composer dependencies');
        $this->executeExternalCommand('composer install', $output);
    }

    protected function installLaravelDependencies(OutputInterface $output)
    {
        $laravelCommands = [
            'mv .env.example .env',
            'php artisan key:generate',
            'php artisan inspire',
        ];
        $output->writeln('Installing Laravel dependencies');
        $this->executeExternalCommand(implode(' && ', $laravelCommands), $output);
    }
}
