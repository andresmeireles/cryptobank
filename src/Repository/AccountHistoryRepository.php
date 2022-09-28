<?php

declare(strict_types=1);

namespace Cryptocli\Repository;

use Cryptocli\Model\AccountHistory;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<AccountHistory>
 */
class AccountHistoryRepository extends Repository implements Interfaces\AccountHistoryRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, AccountHistory::class);
    }
}