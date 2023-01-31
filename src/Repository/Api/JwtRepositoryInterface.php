<?php

namespace CryptoBank\Repository\Api;

use CryptoBank\Model\Jwt;

/**
 * @extends RepositoryInterface<Jwt>
 */
interface JwtRepositoryInterface extends RepositoryInterface
{
    public function getByJwt(string $jwt): ?Jwt;

    public function getByUserId(int $userId): ?Jwt;
}
