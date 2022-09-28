<?php

namespace Cryptocli\Services\Account;

use Cryptocli\Model\AccountHistory;
use Cryptocli\Model\AccountOperations;
use Cryptocli\Services\ServiceError;

interface AccountHistoryRegister
{
    public function add(string $accountCode, float $value): AccountHistory|ServiceError;

    public function withdraw(string $accountCode, float $value): AccountHistory|ServiceError;
}