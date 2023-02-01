<?php

namespace CryptoBank\Repository\Api;

use CryptoBank\Model\User;

/**
 * @extends RepositoryInterface<\CryptoBank\Model\User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function findOneUserByName(string $user): ?User;
}
