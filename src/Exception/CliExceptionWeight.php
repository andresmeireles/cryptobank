<?php

declare(strict_types=1);

namespace CryptoBank\Exception;

enum CliExceptionWeight
{
    CASE WARNING;
    CASE ERROR;
    CASE DEBUG;
    CASE INFO;

    public function toString(): string
    {
        return match($this) {
            self::DEBUG => 'debug',
            self::ERROR => 'error',
            self::INFO => 'info',
            self::WARNING => 'warning'
        };
    }
}

