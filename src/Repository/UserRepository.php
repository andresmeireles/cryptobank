<?php

declare(strict_types=1);

namespace Cryptocli\Repository;

use Cryptocli\Model\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<User>
 */
class UserRepository extends Repository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, User::class);
    }
}