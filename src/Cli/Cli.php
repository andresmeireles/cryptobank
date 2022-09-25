<?php

namespace Cryptocli\Cli;

interface Cli
{
    public function allCommands(): void;

    public function executeCommand(CommandInput $command): string;
}