<?php

namespace Gideon\Core;

use Gideon\Util\Logo;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Command extends BaseCommand
{
    public function run(InputInterface $input, OutputInterface $output)
    {
        Logo::write($output);

        return parent::run($input, $output);
    }

    protected function executeExternalCommand($command, OutputInterface $output)
    {
        $progress = new ProgressBar($output);
        $progress->start();
        $progress->setFormat('debug');

        $process = new Process($command);
        $process->setTimeout(36000);
        $process->enableOutput();

        $process->run(function () use ($process, $progress) {
            $progress->advance();
        });

        $progress->finish();
        $output->write(PHP_EOL);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}
