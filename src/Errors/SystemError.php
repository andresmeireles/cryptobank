<?php

declare(strict_types=1);

namespace CryptoBank\Errors;

enum SystemError implements Error
{
    case ERROR;

    public function message(): string
    {
        return match ($this) {
            self::ERROR => 'erro interno'
        };
    }
}
