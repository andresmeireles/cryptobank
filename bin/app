#!/usr/bin/env php
<?php

use Cryptocli\Commands;
use Symfony\Component\Console\Application;

require __DIR__ . '/../bootstrap/container_bootstrap.php';

$app = new Application('crypto bank');
$commands = new Commands();

foreach ($commands->getCommands() as $command) {
    $app->add($container->get($command));
}

$app->run();