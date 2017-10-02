#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use Gideon\Core\Application;
use Gideon\Commands\CreateApplicationCommand;

$application = new Application();

$application->addCommands([
    new CreateApplicationCommand(),
]);

$application->run();
