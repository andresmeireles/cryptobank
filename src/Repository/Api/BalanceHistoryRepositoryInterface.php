<?php

namespace CryptoBank\Repository\Api;

use CryptoBank\Dto\BalanceHistory as DtoBalanceHistory;
use CryptoBank\Model\Account;
use CryptoBank\Model\BalanceHistory;

/** 
 * @package CryptoBank\Repository\Api
 * @extends RepositoryInterface<BalanceHistory>
 */
interface BalanceHistoryRepositoryInterface extends RepositoryInterface
{
    public function createFromDto(DtoBalanceHistory $balanceHistory): BalanceHistory;

    /**
     * @param Account $account 
     * @return BalanceHistory[] 
     */
    public function findByAccount(Account $account): array;
}
