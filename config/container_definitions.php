<?php

declare(strict_types=1);

use Cryptocli\Cli\Cli;
use Cryptocli\Cli\SymfonyCli;
use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return [
    Cli::class => function (Container $container) {
        $commands = new Cryptocli\Cli\Commands();
        return new SymfonyCli($container, $commands->getSymfonyCommands());
    },
    LoggerInterface::class => function () {
        $log = new Logger('system');
        $log->pushHandler(new StreamHandler(__DIR__ . '/../var/log/system.log', Level::Info));

        return $log;
    }
];
