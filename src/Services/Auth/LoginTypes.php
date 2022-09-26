<?php

namespace Cryptocli\Services\Auth;

use Cryptocli\Services\ServiceError;

interface LoginTypes
{
    public function withUserAndPassword(string $user, string $password): string|ServiceError;

    public function withAccountAndPassword(string $accountNumber, string $password): string|ServiceError;
}