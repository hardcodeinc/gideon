#!/usr/bin/env php
<?php

define('BASE_PATH', __DIR__);

require BASE_PATH.'/../vendor/autoload.php';

use Gideon\Commands\CloneTemplateCommand;
use Gideon\Commands\CreateApplicationCommand;
use Gideon\Commands\InstallDependenciesCommand;
use Gideon\Core\Application;
use Gideon\Commands\ConfigurationWizardCommand;

$application = new Application();

$application->addCommands([
    new CreateApplicationCommand(),
    new ConfigurationWizardCommand(),
    new CloneTemplateCommand(),
    new InstallDependenciesCommand(),
]);

$application->run();
