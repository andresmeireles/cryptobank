<?php

declare(strict_types=1);

namespace CryptoBank\Test;

use CryptoBank\Dto\BalanceOperation;
use CryptoBank\Model\Account;
use CryptoBank\Model\Auth;
use CryptoBank\Model\Balance;
use CryptoBank\Model\BalanceHistory;
use CryptoBank\Model\Jwt;
use CryptoBank\Model\User;
use CryptoBank\Utils\SodiumEncrypt;
use PHPUnit\Framework\MockObject\MockObject;

trait Helper
{
    public function user(int $id = 1): User|MockObject
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn($id);
        return $user;
    }

    public function auth(): Auth|MockObject
    {
        return $this->createMock(Auth::class);
    }

    public function jwt(): Jwt|MockObject
    {
        return $this->createMock(Jwt::class);
    }

    public function account(): Account|MockObject
    {
        return $this->createMock(Account::class);
    }

    public function balance(float $value = 10, int $accountId = 1): Balance|MockObject
    {
        $enc = new SodiumEncrypt();
        $balance = $this->createMock(Balance::class);
        $balance->account = $enc->encrypt((string) $accountId);
        $balance->balance = $enc->encrypt((string) $value);
        $balance->updatedAt = $enc->encrypt((string) (new \DateTime())->getTimestamp());
        return $balance;
    }

    public function balanceHistory(float $value = 1, BalanceOperation $balanceOperation = BalanceOperation::ADD, int $accountId = 1, int $balanceId = 1, \DateTime $createdAt = new \DateTime()): BalanceHistory|MockObject
    {
        $enc = new SodiumEncrypt();
        $balanceHistory = $this->createMock(BalanceHistory::class);
        $balanceHistory->account = $enc->encrypt((string)$accountId);
        $balanceHistory->balance = $enc->encrypt((string) $balanceId);
        $balanceHistory->operation = $enc->encrypt($balanceOperation->value);
        $balanceHistory->value = $enc->encrypt((string) $value);
        $balanceHistory->createdAt = $enc->encrypt((string) $createdAt->getTimestamp());
        return $balanceHistory;
    }
}
