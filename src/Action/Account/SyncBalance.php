<?php

declare(strict_types=1);

namespace CryptoBank\Action\Account;

use CryptoBank\Dto\BalanceHistory as DtoBalanceHistory;
use CryptoBank\Model\Account;
use CryptoBank\Model\BalanceHistory;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\BalanceHistoryRepositoryInterface;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;
use CryptoBank\Utils\Api\DecryptInterface;

class SyncBalance
{
    public function __construct(
        private readonly BalanceHistoryRepositoryInterface $balanceHistoryRepository,
        private readonly BalanceRepositoryInterface $balanceRepository,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly DecryptInterface $decrypt,
    ) {}

    public function sync(Account $account)
    {
        $history = $this->balanceHistoryRepository->findByAccount($account);
        $toDto = array_map(
            function (BalanceHistory $item) {
                $accountId = $this->decrypt->decrypt($item->account);
                $account = $this->accountRepository->find($accountId);
                $balanceId = $this->decrypt->decrypt($item->balance);
                $balance = $this->balanceRepository->find($balanceId); 
                return new DtoBalanceHistory(
                    balance:,
                    account:,
                    operation:,
                    value:,
                    createdAt:,
                );
            },
           $history 
        );
    }
}
