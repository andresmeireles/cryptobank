<?php

declare(strict_types=1);

namespace Cryptocli\Repository;

use Cryptocli\Model\Account;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<Account>
 */
class AccountRepository extends Repository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Account::class);
    }
}