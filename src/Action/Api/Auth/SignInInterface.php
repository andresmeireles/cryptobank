<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api\Auth;

use CryptoBank\Errors\Error;
use CryptoBank\Model\User;

interface SignInInterface
{
    public function withJwt(string $jwt): User|Error;

    public function withPassword(string $user, string $password): User|Error;
}
