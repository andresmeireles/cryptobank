<?php

namespace Cryptocli\Services\Auth;

use Cryptocli\Model\User;
use Cryptocli\Services\ServiceError;

interface TokenValidation
{
    public function validate(string $token): bool;

    public function userToken(string $token): User|ServiceError;
}