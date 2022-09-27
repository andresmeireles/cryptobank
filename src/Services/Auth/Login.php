<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\CommomErrors;
use Cryptocli\Services\ServiceError;

class Login implements LoginTypes
{
    public function __construct(
        private readonly Jwt $jwt,
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function withUserAndPassword(int $user, string $password): string|ServiceError
    {
        $user = $this->userRepository->find($user);
        if ($user === null) {
            return CommomErrors::USER_NOT_FOUND;
        }
        $auth = $user->auth;
        if (!password_verify($password, $auth->password)) {
            return AuthErrors::WRONG_CREDENTIALS;
        }

    }

    public function withAccountAndPassword(string $accountNumber, string $password): string|ServiceError
    {
        // TODO: Implement withAccountAndPassword() method.
    }
}