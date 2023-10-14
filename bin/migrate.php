#!/usr/bin/env php
<?php

use Monolog\Logger;
use Migration\Command\TasksChain;
use Monolog\Handler\StreamHandler;
use Migration\Command\MigrationOne;
use Migration\Command\MigrationTwo;
use Migration\Command\MigrationThree;
use Symfony\Component\Console\Application;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$loggerScripts = new Logger('scripts');
$loggerScripts->pushHandler(
        new StreamHandler(sprintf(
                realpath('.') . '/logs/suivi-scripts-%s.log',
                date('d-m-Y')), Logger::DEBUG)
);

$application = new Application();

$application->add(new MigrationOne($loggerScripts));
$application->add(new MigrationTwo($loggerScripts));
$application->add(new MigrationThree($loggerScripts));
$application->add(new TasksChain($loggerScripts));

try {
    $application->run();
} catch (Exception $e) {
    echo $e->getMessage();

    return 1;
}