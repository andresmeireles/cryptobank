<?php

namespace Cryptocli\Services;

enum CommomErrors implements ServiceError
{
    case USER_NOT_FOUND;
    case ACCOUNT_NOT_FOUND;

    public function errorMessage(): string
    {
        return match ($this) {
            self::USER_NOT_FOUND => 'user not found or not exists',
            self::ACCOUNT_NOT_FOUND => 'account not found or not exists'
        };
    }
}