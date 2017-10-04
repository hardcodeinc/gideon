<?php

namespace Gideon\Commands;

use Gideon\Core\Command;
use Gideon\Util\Configuration;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ConfigurationWizardCommand extends Command
{
    protected $configuration;

    protected function configure()
    {
        $this
            ->setName('config')
            ->setDescription('Configure Gideon for use.')
            ->addOption(
                'global',
                'g',
                InputOption::VALUE_OPTIONAL,
                'Create the configuration file globally?',
                false
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('====================================================');
        $output->writeln(PHP_EOL.'Configuration Wizzard'.PHP_EOL);
        $output->writeln('====================================================');

        $urlNormalizer = function ($value) {
            if (strpos('http://', $value) === false) {
                $value = 'http://'.$value;
            }

            return $value;
        };

        $this->configuration['git']['base-url'] = $this->makeQuestion(implode(PHP_EOL, [
            'Please enter the git base url:',
            '(Eg.: <info>https://github.com/your-username/</info>)',
        ]), $urlNormalizer);

        $this->configuration['git']['application-repository'] = $this->makeQuestion(implode(PHP_EOL, [
            'Please enter the application template repository:',
            '(Eg.: <info>https://github.com/your-username/your-app-template-repository.git</info>)',
        ]), $urlNormalizer);

        $this->configuration['git']['module-repository'] = $this->makeQuestion(implode(PHP_EOL, [
            'Please enter the module template repository:',
            '(Eg.: <info>https://github.com/your-username/your-module-template-repository.git</info>)',
        ]), $urlNormalizer);

        $this->configuration['git']['domain-repository'] = $this->makeQuestion(implode(PHP_EOL, [
            'Please enter the domain template repository:',
            '(Eg.: <info>https://github.com/your-username/your-domain-repository.git</info>)',
        ]), $urlNormalizer);

        $this->configuration['module']['destination'] = $this->makeQuestion(implode(PHP_EOL, [
            'Please enter the module destination directory:',
            '(Eg.: <info>app/Modules/</info>)',
        ]));

        $this->configuration['module']['namespace'] = $this->makeQuestion(implode(PHP_EOL, [
            'Please enter the module base namespace:',
            '(Eg.: <info>App\Modules</info>)',
        ]));

        $file = 'gideon.json';
        $global = $input->getOption('global') !== false;

        if ($input->getOption('global') !== false) {
            $file = sprintf('%s/%s', BASE_PATH, $file);
        }

        Configuration::writeToFile($this->configuration, $file);
    }
}
