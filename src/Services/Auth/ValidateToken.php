<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\ServiceError;

class ValidateToken implements TokenValidation
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly Jwt $jwt,
    )
    {
    }

    public function validate(string $token): bool
    {
        $jwtToken = $this->jwt->decode($token);
        $user = $this->userRepository->find($jwtToken->userId);

        return $user !== null && !$jwtToken->isExpired();
    }

    public function userToken(string $token): User|ServiceError
    {
        $jwtToken = $this->jwt->decode($token);
        if (!$this->validate($token)) {
            return AuthErrors::INVALID_TOKEN;
        }
        $user = $this->userRepository->find($jwtToken->userId);
        if ($user === null) {
            return AuthErrors::NO_USER_TOKEN;
        }

        return $user;
    }
}