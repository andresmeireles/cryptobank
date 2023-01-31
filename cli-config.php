<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

$em = require __DIR__ . '/bootstrap/doctrine_bootstrap.php';

// hack para fazer o script doctrine-migration funcionar.
if (isset($argv[0]) && $argv[0] === 'vendor/bin/doctrine') {
    ConsoleRunner::run(new SingleManagerProvider($em), []);
    return;
}

$config = new PhpFile(__DIR__ . '/config/doctrine_migration_config.php');
return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($em));
