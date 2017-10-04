#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Gideon\Commands\CloneTemplateCommand;
use Gideon\Commands\CreateApplicationCommand;
use Gideon\Commands\InstallDependenciesCommand;
use Gideon\Core\Application;

$application = new Application();

$application->addCommands([
    new CreateApplicationCommand(),
    new CloneTemplateCommand(),
    new InstallDependenciesCommand(),

]);

$application->run();
