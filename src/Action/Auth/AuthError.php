<?php

namespace CryptoBank\Action\Auth;

use CryptoBank\Errors\Error;

enum AuthError implements Error
{
    case INVALID_USER;
    case INVALID_JWT;

    public function message(): string
    {
        return match($this) {
            self::INVALID_USER => 'usuario/conta não encontrada ou senha incorreta',
            self::INVALID_JWT => 'jwt invalido',
        };
    }
}
