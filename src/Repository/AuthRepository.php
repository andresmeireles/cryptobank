<?php

namespace Cryptocli\Repository;

use Cryptocli\Model\Auth;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<Auth>
 */
class AuthRepository extends Repository implements Interfaces\AuthRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Auth::class);
    }
}