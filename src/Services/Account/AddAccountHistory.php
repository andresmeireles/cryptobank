<?php

namespace Cryptocli\Services\Account;

use Cryptocli\Model\Account;
use Cryptocli\Model\AccountHistory;
use Cryptocli\Model\AccountOperations;
use Cryptocli\Repository\AccountRepository;
use Cryptocli\Repository\Interfaces\AccountHistoryRepository;
use Cryptocli\Services\CommomErrors;
use Cryptocli\Services\ServiceError;

class AddAccountHistory implements AccountHistoryRegister
{
    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly AccountHistoryRepository $accountHistoryRepository
    )
    {
    }

    public function add(string $accountCode, float $value): AccountHistory|ServiceError
    {
        $account = $this->getAccount($accountCode);
        if ($account instanceof ServiceError) {
            return $account;
        }

        return $this->operation($account, AccountOperations::DEPOSIT, $value);
    }


    public function withdraw(string $accountCode, float $value): AccountHistory|ServiceError
    {
        $account = $this->getAccount($accountCode);
        if ($account instanceof ServiceError) {
            return $account;
        }
        if ($account->balance === 0.0) {
            return AccountErrors::NO_FOUNDS_TO_WITHDRAW;
        }

        return $this->operation($account, AccountOperations::WITHDRAW, $value);
    }

    private function getAccount(string $accountCode): Account|ServiceError
    {
        $account = $this->accountRepository->findOneBy(['number' => $accountCode]);
        if ($account === null) {
            return CommomErrors::ACCOUNT_NOT_FOUND;
        }

        return $account;
    }

    private function operation(Account $account, AccountOperations $operations, float $value): AccountHistory
    {
        $register = AccountHistory::create($account, $operations, $value);

        return $this->accountHistoryRepository->create($register);
    }
}