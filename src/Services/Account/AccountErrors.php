<?php

namespace Cryptocli\Services\Account;

use Cryptocli\Services\ServiceError;

enum AccountErrors implements ServiceError
{
    case NO_FOUNDS_TO_WITHDRAW;

    public function errorMessage(): string
    {
        return match($this) {
          self::NO_FOUNDS_TO_WITHDRAW => 'no founds to withdraw'
        };
    }
}
