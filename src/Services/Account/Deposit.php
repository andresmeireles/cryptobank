<?php

namespace Cryptocli\Services\Account;

use Cryptocli\Repository\Interfaces\AccountRepository;

class Deposit implements Add
{
    public function __construct(
        private readonly AccountRepository $accountRepository
    )
    {
    }

    public function deposit(string $accountCode, float $value): void
    {
        $account = $this->accountRepository->findOneBy(['number' => $accountCode]);
    }
}