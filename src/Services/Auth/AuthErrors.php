<?php

namespace Cryptocli\Services\Auth;

use Cryptocli\Services\ServiceError;

enum AuthErrors implements ServiceError
{
    case WRONG_CREDENTIALS;

    public function errorMessage(): string
    {
        return match($this) {
            self::WRONG_CREDENTIALS => 'wrong credentials'
        };
    }
}
