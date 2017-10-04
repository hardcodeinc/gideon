<?php

namespace Gideon\Core;

use Gideon\Util\Logo;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Command extends BaseCommand
{
    protected $input;

    protected $output;

    public function run(InputInterface $input, OutputInterface $output)
    {
        Logo::write($output);
        $this->input = $input;
        $this->output = $output;

        return parent::run($input, $output);
    }

    protected function executeExternalCommand($command, OutputInterface $output)
    {
        // $progress = new ProgressBar($output);
        // $progress->start();
        // $progress->setFormat('debug');

        $process = new Process($command);
        $process->setTimeout(36000);
        $process->enableOutput();

        $process->run(function () {
            // $progress->advance();
        });

        // $progress->finish();
        // $output->write(PHP_EOL);

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }

    protected function makeQuestion($questionText, callable $normalizer = null)
    {
        $value = null;
        $helper = $this->getHelper('question');
        $question = new Question(PHP_EOL.$questionText.PHP_EOL);

        if ($normalizer) {
            $question->setNormalizer($normalizer);
        }

        while (! $value) {
            $value = $helper->ask($this->input, $this->output, $question);
        }

        return $value;
    }
}
