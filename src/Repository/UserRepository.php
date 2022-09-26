<?php

namespace Cryptocli\Repository;

use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
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