<?php

namespace Cryptocli\Services\Account;

interface CheckAccount
{
    public function checkUserAccount(string $account, int $userId): bool;
}