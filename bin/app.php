#!/usr/bin/env php
<?php

use Cryptocli\Cli\Cli;

require __DIR__ . '/../bootstrap/container_bootstrap.php';


$app = $container->get(Cli::class);

$app->allCommands();