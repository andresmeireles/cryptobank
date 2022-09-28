<?php

namespace Cryptocli\Services\Auth;

use Cryptocli\Services\ServiceError;

enum AuthErrors implements ServiceError
{
    case WRONG_CREDENTIALS;
    case EXPIRED_TOKEN;
    case INVALID_TOKEN;
    case NO_USER_TOKEN;

    public function errorMessage(): string
    {
        return match($this) {
            self::WRONG_CREDENTIALS => 'wrong credentials',
            self::EXPIRED_TOKEN => 'token is expired',
            self::NO_USER_TOKEN => 'token was not associated to an user',
            self::INVALID_TOKEN => 'token invalid',
        };
    }
}
