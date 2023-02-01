<?php

declare(strict_types=1);

namespace CryptoBank\Repository\Api;

use CryptoBank\Model\Auth;

/**
 * @extends RepositoryInterface<Auth>
 */
interface AuthRepositoryInterface extends RepositoryInterface 
{
    public function getByUserId(int $id): ?Auth;

    public function getByAccountId(int $id): ?Auth;
}
