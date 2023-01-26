<?php

declare(strict_types=1);

namespace Cryptocli\Action;

use Cryptocli\Errors\Error;

enum ActonErrors implements Error
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
            self::INVALID => 'dados invalidos',
            self::INVALID_CPF_CNPJ => 'cpf ou cnpj invalido',
            self::INVALID_NAME => 'nome invalido',
            self::INVALID_DATE => 'data invalido',
            self::INVALID_ADDRESS => 'endereço invalido',
            self::INVALID_PHONE => 'telefone invalido',
            self::INVALID_RG => 'rg/ie invalido'
        };
    }
}