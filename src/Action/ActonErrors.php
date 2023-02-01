<?php

declare(strict_types=1);

namespace CryptoBank\Action;

use CryptoBank\Errors\Error;

enum ActonErrors implements Error
{
    case INVALID;
    case INVALID_CPF_CNPJ;
    case INVALID_NAME;
    case INVALID_DATE;
    case INVALID_ADDRESS;
    case INVALID_PHONE;
    case INVALID_RG; 
}
