<?php

declare(strict_types=1);

namespace CryptoBank\Action;

use CryptoBank\Errors\Error;

enum ActionErrors implements Error
{
    case INVALID;
    case INVALID_CPF_CNPJ;
    case INVALID_NAME;
    case INVALID_DATE;
    case INVALID_ADDRESS;
    case INVALID_PHONE;
    case INVALID_RG;

    public function message(): string
    {
        return match($this) {
            self::INVALID_RG => 'rg invalido',
            self::INVALID_NAME => 'nome incorreto ou invalido',
            self::INVALID_DATE => 'data invalida',
            self::INVALID_ADDRESS => 'endereço invalido',
            self::INVALID_PHONE => 'numero de telefone invalido',
            self::INVALID_CPF_CNPJ => 'cpf ou cnpj invalido',
            self::INVALID => 'campo invalido'
        };
    } 
}
