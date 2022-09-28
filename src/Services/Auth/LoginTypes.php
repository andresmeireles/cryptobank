<?php

namespace Cryptocli\Services\Auth;

use Cryptocli\Model\AuthToken;
use Cryptocli\Services\ServiceError;

interface LoginTypes
{
    public function withUserAndPassword(string $userName, string $password): AuthToken|ServiceError;

    public function withAccountAndPassword(string $accountNumber, string $password): string|ServiceError;
}