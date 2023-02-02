<?php

namespace CryptoBank\Action\Account;

use CryptoBank\Errors\Error;

enum AccountError implements Error
{
    case NO_BALANCE;

    public function message(): string
    {
        return match($this) {
            self::NO_BALANCE => 'balance not exists'
        };
    }
}
