<?php

namespace CryptoBank\Action\Api\Account;

use CryptoBank\Model\Account;
use CryptoBank\Model\Balance;

interface CreateInterface
{
    public function create(Account $account): Balance;
}
