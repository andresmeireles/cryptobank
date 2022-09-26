<?php

declare(strict_types=1);

namespace Cryptocli\Services\Register;

use Cryptocli\DTO\CreateUser;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\ServiceError;

class NewUser implements CreateNewUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function create(CreateUser $userData): User|ServiceError
    {
        $user = $userData->toUser();

        return $this->userRepository->create($user);
    }
}