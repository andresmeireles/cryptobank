<?php

declare(strict_types=1);

namespace CryptoBank\Repository;

use CryptoBank\Model\Auth;
use CryptoBank\Repository\Api\AuthRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<Auth>
 */
class AuthRepository extends Repository implements AuthRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Auth::class); 
    }

    public function getByUserId(int $id): ?Auth
    {
        return $this->findOneBy(['user' => $id]);
    }

    public function getByAccountId(int $id): ?Auth
    {
        return $this->findOneBy(['account' => $id]);
    }
}
