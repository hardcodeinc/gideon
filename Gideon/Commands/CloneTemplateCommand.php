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

class CloneTemplateCommand extends Command
{
    protected function configure()
    {
        $this->setName('clone')
             ->setDescription("Clone template repository for use")
             ->addArgument('destination', InputArgument::REQUIRED, 'Project destination folder');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // destination folder of the application.
        $destination = $input->getArgument('destination') ?: 'gideon';

        // clone the template repository.
        $output->writeln(sprintf('Cloning template repository on %s, please wait...', $destination));
        $this->executeExternalCommand(sprintf('git clone https://gitlab.com/carlosfiori/teste.git %s', $destination), $output);
        $output->writeln('Application created');

        //delete .git folder from template
        $afterCloneCommands = [
            sprintf('cd %s', $destination),
            'rm -rf .git',
        ];
        $this->executeExternalCommand(implode(' && ', $afterCloneCommands), $output);
    }
}
