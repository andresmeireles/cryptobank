<?php

namespace CryptoBank\Repository\Api;

use CryptoBank\Dto\Balance as DtoBalance;
use CryptoBank\Model\Account;
use CryptoBank\Model\Balance;

/**
 * @extends RepositoryInterface<Balance>
 */
interface BalanceRepositoryInterface extends RepositoryInterface
{
    public function createFromDto(DtoBalance $balance): Balance;

    public function findOneByAccount(Account $account): ?Balance;
}
