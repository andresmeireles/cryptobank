<?php

declare(strict_types=1);

use Cryptocli\Cli\Cli;
use Cryptocli\Cli\SymfonyCli;
use DI\Container;

return [
    Cli::class => static function (Container $container) {
        $commands = new Cryptocli\Cli\Commands();
        return new SymfonyCli($container, $commands->getSymfonyCommands());
    }
];
