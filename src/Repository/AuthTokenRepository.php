<?php

namespace Cryptocli\Repository;

use Cryptocli\Model\AuthToken;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<AuthToken>
 */
class AuthTokenRepository extends Repository implements Interfaces\AuthTokenRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, AuthToken::class);
    }
}