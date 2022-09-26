<?php

declare(strict_types=1);

namespace Cryptocli\Services\Register;

use Cryptocli\DTO\CreateUser;
use Cryptocli\Model\User;
use Cryptocli\Services\ServiceError;

interface CreateNewUser
{
    public function create(CreateUser $userData): User|ServiceError;
}