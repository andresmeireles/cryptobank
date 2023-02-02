<?php

declare(strict_types=1);

namespace CryptoBank\Action\Account;

use CryptoBank\Action\Api\Account\CreateInterface;
use CryptoBank\Dto\Balance as DtoBalance;
use CryptoBank\Model\Account;
use CryptoBank\Model\Balance;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;

class Create implements CreateInterface
{
    public function __construct(
        private readonly BalanceRepositoryInterface $balanceRepository
    ) {}

    public function create(Account $account): Balance
    { 
        $dto = new DtoBalance(account: $account, balance: 0, updatedAt: new \DateTime());
        return $this->balanceRepository->createFromDto($dto);
    }
}
