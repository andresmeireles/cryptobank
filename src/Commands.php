<?php

namespace Cryptocli;

use Cryptocli\Cli\Commands\Message;

class Commands
{
    /**
     * @var string-class[]
     */
    private array $commands = [
        Message::class
    ];

    public function getCommands(): array
    {
        return $this->commands;
    }
}