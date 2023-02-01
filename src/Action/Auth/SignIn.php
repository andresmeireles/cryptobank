<?php

declare(strict_types=1);

namespace CryptoBank\Action\Auth;

use CryptoBank\Action\Api\Auth\SignInInterface;
use CryptoBank\Errors\Error;
use CryptoBank\Model\User;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\AuthRepositoryInterface;
use CryptoBank\Repository\Api\JwtRepositoryInterface;
use CryptoBank\Repository\Api\UserRepositoryInterface;

class SignIn implements SignInInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly AuthRepositoryInterface $authRepository,
        private readonly JwtRepositoryInterface $jwtRepository,
    ) {}

    public function withJwt(string $jwt): User|Error
    {
        $token = $this->jwtRepository->getByJwt($jwt);
        if ($token === null) {
            return AuthError::INVALID_JWT;
        } 
        return $token->user;
    }

    /**
     * Login user with user name or account number and password
     *
     * @param string $userName 
     * @param string $password 
     * @return User|Error 
     */
    public function withPassword(string $userName, string $password): User|Error
    {
        $user = $this->userRepository->findOneUserByName($userName); 
        $account = $this->accountRepository->find((int) $userName);
        if ($user === null && $account === null) {
            return AuthError::INVALID_USER;
        }
        $u = $user ?? $account->user;
        $auth = $this->authRepository->getByUserId($u->getId());
        if ($auth === null) {
            return AuthError::INVALID_USER;
        }
        $isPasswordValid = password_verify($password, $auth->password);
        if (!$isPasswordValid) {
            return AuthError::INVALID_USER;
        }
        return $auth->user;
    }
}
