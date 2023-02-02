<?php

declare(strict_types=1);

namespace CryptoBank\Action\Account;

use CryptoBank\Dto\BalanceHistory as DtoBalanceHistory;
use CryptoBank\Dto\BalanceOperation;
use CryptoBank\Model\Account;
use CryptoBank\Model\BalanceHistory;
use CryptoBank\Repository\Api\BalanceHistoryRepositoryInterface;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;

class AddBalance
{
    public function __construct(
        private readonly BalanceHistoryRepositoryInterface $balanceHistoryRepository,
        private readonly BalanceRepositoryInterface $balanceRepository,
    )
    {
    }

    public function add(Account $account, float $value, BalanceOperation $balanceOperation): BalanceHistory
    {
        $balance = $this->balanceRepository->findOneByAccount($account);
        $dto = new DtoBalanceHistory($balance, $account, $balanceOperation, $value, new \DateTime());
        return $this->balanceHistoryRepository->createFromDto($dto);
    }
}
