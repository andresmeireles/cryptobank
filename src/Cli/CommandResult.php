<?php

namespace Cryptocli\Cli;

class CommandResult
{
    public function __construct(
        public readonly int $statusCode,
        public readonly string $message
    )
    {
    }
}