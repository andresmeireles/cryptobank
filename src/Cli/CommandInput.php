<?php

namespace CryptoBank\Cli;

class CommandInput
{
    public function __construct(
        public readonly string $commandName,
        public readonly array $arguments
    )
    {
    }
}