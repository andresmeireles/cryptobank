<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

use Cryptocli\Services\ServiceError;

class Login implements AuthTypes
{
    public function withUserAndPassword(string $user, string $password): string|ServiceError
    {
        // TODO: Implement withUserAndPassword() method.
    }

    public function withAccountAndPassword(string $accountNumber, string $password): string|ServiceError
    {
        // TODO: Implement withAccountAndPassword() method.
    }
}