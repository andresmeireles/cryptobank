<?php

namespace Cryptocli;

use Cryptocli\Cli\Commands\MessageCommand;

class Commands
{
    /**
     * @var string-class[]
     */
    private array $commands = [
        MessageCommand::class
    ];

    public function getCommands(): array
    {
        return $this->commands;
    }
}