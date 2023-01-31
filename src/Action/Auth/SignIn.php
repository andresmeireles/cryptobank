<?php

declare(strict_types=1);

namespace CryptoBank\Action\Auth;

use CryptoBank\Action\Api\Auth\SignInInterface;
use CryptoBank\Model\User;
use CryptoBank\Repository\Api\JwtRepositoryInterface;
use CryptoBank\Errors\Error;
use CryptoBank\Repository\Api\UserRepositoryInterface;


class SignIn implements SignInInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JwtRepositoryInterface $jwtRepository
    ) { 
    }

    public function withJwt(string $jwt): User|Error
    {
        $jwt = $this->jwtRepository->getByJwt($jwt);
        if ($jwt === null) {
            return AuthError::USER_NOT_FOUND; 
        }
        return $jwt->user;
    }

    public function withPassword(string $user, string $password): User|Error
    {
        
    }
}
