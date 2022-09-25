<?php

namespace Cryptocli\Cli;

use Cryptocli\Cli\Command\MessageCommand;

class Commands
{
    /**
     * @var class-string[]|string[]
     */
    private array $symfonyCommands = [
        MessageCommand::class
    ];

    /**
     * @return class-string[]|string[]
     */
    public function getSymfonyCommands(): array
    {
        return $this->symfonyCommands;
    }
}