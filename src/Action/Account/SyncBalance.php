<?php

declare(strict_types=1);

namespace CryptoBank\Action\Account;

use CryptoBank\Dto\BalanceOperation;
use CryptoBank\Errors\Error;
use CryptoBank\Model\Account;
use CryptoBank\Model\Balance as ModelBalance;
use CryptoBank\Model\BalanceHistory;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\BalanceHistoryRepositoryInterface;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;
use CryptoBank\Utils\Api\DecryptInterface;
use CryptoBank\Utils\Api\EncryptInterface;

class SyncBalance
{
    public function __construct(
        private readonly BalanceHistoryRepositoryInterface $balanceHistoryRepository,
        private readonly BalanceRepositoryInterface $balanceRepository,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly DecryptInterface $decrypt,
        private readonly EncryptInterface $encrypt,
    ) {
    }

    public function sync(Account $account): Error|ModelBalance
    {
        $history = $this->balanceHistoryRepository->findByAccount($account);
        $balance = $this->balanceRepository->findOneByAccount($account);
        if ($balance === null) {
            return AccountError::NO_BALANCE;
        }
        $accountId = $this->decrypt->decrypt($balance->account);
        $account = $this->accountRepository->find((int) $accountId);
        $totalPrice = array_reduce(
            $history,
            function (float $total, BalanceHistory $bh) {
                $operation = BalanceOperation::from($this->decrypt->decrypt($bh->operation));
                $value = (float) $this->decrypt->decrypt($bh->value);
                $operationValue = $operation === BalanceOperation::MINUS ? $value * -1 : $value;
                return $total + $operationValue;
            },
            0.0
        );
        $balance->balance = $this->encrypt->encrypt((string) $totalPrice);
        $balance->updatedAt = $this->encrypt->encrypt((string) (new \DateTime())->getTimestamp());
        return $this->balanceRepository->update($balance);
    }

    public function lastBalanceSync(Account $account, BalanceHistory $balanceHistory): Error|ModelBalance
    {
        $operation = BalanceOperation::from($this->decrypt->decrypt($balanceHistory->operation));
        $value = (float) $this->decrypt->decrypt($balanceHistory->value);
        $operationValue = $operation === BalanceOperation::MINUS ? $value * -1 : $value;
        $balance = $this->balanceRepository->findOneByAccount($account);
        if ($balance === null) {
            return AccountError::NO_BALANCE;
        }
        $currentBalance = (float) $this->decrypt->decrypt($balance->balance);
        $balance->balance = $this->encrypt->encrypt((string) ($currentBalance + $operationValue));
        return $this->balanceRepository->update($balance);
    }
}
