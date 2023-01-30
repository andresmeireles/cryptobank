<?php

declare(strict_types=1);

namespace CryptoBank\Repository;

use CryptoBank\Model\User;
use CryptoBank\Repository\Api\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<User>
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, User::class);
    }
}