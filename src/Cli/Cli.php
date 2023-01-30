<?php

namespace CryptoBank\Cli;

interface Cli
{
    public function allCommands(): void;

    public function executeCommand(CommandInput $command): string;
}