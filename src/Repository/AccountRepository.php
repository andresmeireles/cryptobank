<?php

declare(strict_types=1);

namespace Cryptocli\Repository;

use Cryptocli\Model\Account;
use Cryptocli\Repository\Api\AccountRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<Account>
 */
class AccountRepository extends Repository implements AccountRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, Account::class);
    }
}
