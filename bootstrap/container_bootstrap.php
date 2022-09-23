<?php

require __DIR__ . '/bootstrap.php';

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/container_definitions.php');
$container = $containerBuilder->build();
