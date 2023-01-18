<?php

namespace Cryptocli\Cli;

use Cryptocli\Cli\Commands\AddCustomer;
use Cryptocli\Cli\Commands\Message;

class Commands
{
    /**
     * @var class-string[]|string[]
     */
    private array $symfonyCommands = [
        Message::class,
        AddCustomer::class
    ];

    /**
     * @return class-string[]|string[]
     */
    public function getSymfonyCommands(): array
    {
        return $this->symfonyCommands;
    }
}