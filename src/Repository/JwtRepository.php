<?php

namespace CryptoBank\Repository;

use CryptoBank\Model\Jwt;
use CryptoBank\Repository\Api\JwtRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<Jwt>
 */
class JwtRepository extends Repository implements JwtRepositoryInterface
{
    public function __construct(EntityManagerInterface $em) {
        parent::__construct($em, Jwt::class);
    }

    public function getByJwt(string $jwt): ?Jwt
    {
        return $this->findOneBy(['token' => $jwt]);
    }

    public function getByUserId(int $userId): ?Jwt
    {
        return $this->findOneBy(['user' => $userId]);
    }
}
