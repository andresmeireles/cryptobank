<?php

declare(strict_types=1);

namespace Cryptocli\Errors;

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
