<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

use Cryptocli\Services\ServiceError;

class Login implements LoginTypes
{
    public function withUserAndPassword(string $user, string $password): string|ServiceError
    {
    }

    public function withAccountAndPassword(string $accountNumber, string $password): string|ServiceError
    {
        // TODO: Implement withAccountAndPassword() method.
    }
}