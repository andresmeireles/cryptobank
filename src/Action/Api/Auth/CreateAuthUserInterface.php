<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api\Auth;

use CryptoBank\Model\Account;
use CryptoBank\Model\Auth;
use CryptoBank\Model\User;

interface CreateAuthUserInterface
{
    public function create(User $user, Account $account, ?string $password = null): Auth;
}
