<?php

namespace CryptoBank\Action\Auth;

use CryptoBank\Errors\Error;

enum AuthError implements Error
{
    case USER_NOT_FOUND;

    public function message(): string
    {
        return match($this) {
            self::USER_NOT_FOUND => 'usuario não encontrado'
        };
    }
}
