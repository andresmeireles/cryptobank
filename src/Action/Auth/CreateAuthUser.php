<?php

declare(strict_types=1);

namespace CryptoBank\Action\Auth;

use CryptoBank\Action\Api\Auth\CreateAuthUserInterface;
use CryptoBank\Model\User;
use CryptoBank\Model\Account;
use CryptoBank\Model\Auth;
use CryptoBank\Repository\Api\AuthRepositoryInterface;

class CreateAuthUser implements CreateAuthUserInterface
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository,
    ) {}

    public function create(User $user, Account $account, ?string $password = null): Auth
    {
        $hashedPassword = $this->hashPassword($password ?? $user->cnpjCpf);
       $auth = Auth::create($user, $account, $hashedPassword);  
        return $this->authRepository->create($auth);
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
