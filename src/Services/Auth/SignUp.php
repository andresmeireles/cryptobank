<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

use Cryptocli\Model\Auth;
use Cryptocli\Repository\Interfaces\AuthRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\CommomErrors;
use Cryptocli\Services\ServiceError;
use Psr\Log\LoggerInterface;

class SignUp implements SignUpTypes

{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function createSignUp(int $userId, string $nonHashedPassword): Auth|ServiceError
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            return CommomErrors::USER_NOT_FOUND;
        }
        $password = password_hash($nonHashedPassword, PASSWORD_ARGON2I);
        $authData = Auth::create($user, $password);
        $auth = $this->authRepository->create($authData);
        $this->logger->info(sprintf('auth created for user %s', $user->getId()));

        return $auth;
    }
}