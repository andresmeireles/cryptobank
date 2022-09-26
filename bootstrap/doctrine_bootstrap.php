<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require __DIR__ . '/bootstrap.php';

$paths = [__DIR__ . '/../src/Model'];
$isDevMode = filter_var($_ENV['DEV_MODE'], FILTER_VALIDATE_BOOL);

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'host'     => $_ENV['DB_HOST'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'dbname'   => $_ENV['DB_NAME'],
);

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: $paths,
    isDevMode: $isDevMode,
);

return $entityManager = EntityManager::create($dbParams, $config);
