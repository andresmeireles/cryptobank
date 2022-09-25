<?php

namespace Cryptocli\Cli;

class CommandInput
{
    public function __construct(
        public readonly string $commandName,
        public readonly array $arguments
    )
    {
    }
}