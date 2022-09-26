<?php

namespace Cryptocli\Services\Register;

use Cryptocli\Services\ServiceError;

enum RegisterErrors implements ServiceError
{
    case USER_NOT_FOUND;


    public function errorMessage(): string
    {
        return match($this) {
            self::USER_NOT_FOUND => 'user not found or not exists'
        };
    }
}
