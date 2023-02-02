<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action\Account;

use CryptoBank\Action\Account\SyncBalance;
use CryptoBank\Dto\BalanceOperation;
use CryptoBank\Model\Balance;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\BalanceHistoryRepositoryInterface;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;
use CryptoBank\Test\Helper;
use CryptoBank\Utils\SodiumDecrypt;
use CryptoBank\Utils\SodiumEncrypt;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class SyncBalanceTest extends TestCase
{
    use Helper;

    private SyncBalance $action;
    private BalanceHistoryRepositoryInterface $bhr;
    private BalanceRepositoryInterface $br;
    private AccountRepositoryInterface $ar;

    protected function setUp(): void
    {
        $this->br = $this->createMock(BalanceRepositoryInterface::class);
        $this->bhr = $this->createMock(BalanceHistoryRepositoryInterface::class);
        $this->ar = $this->createMock(AccountRepositoryInterface::class);
        $d = new SodiumDecrypt();
        $e = new SodiumEncrypt();
        $this->action = new SyncBalance(
            balanceRepository: $this->br,
            balanceHistoryRepository: $this->bhr,
            accountRepository: $this->ar,
            decrypt: $d,
            encrypt: $e,
        );
    }

    /**
     * @covers \CryptoBank\Action\Account\SyncBalance::sync 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testSync(): void
    {
        $balance = $this->balance();
        $this->br->method('findOneByAccount')->willReturn($balance);
        $this->br->method('update')->willReturnCallback(fn ($p) => $p);
        $account = $this->account();
        $result = $this->action->sync($account);
        self::assertTrue($result instanceof Balance);
    }

    /**
     * @covers \CryptoBank\Action\Account\SyncBalance::sync 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testValueOfSync(): void
    {
        $balance = $this->balance(value: 0);
        $this->br->method('findOneByAccount')->willReturn($balance);
        $this->br->method('update')->willReturnCallback(fn ($p) => $p);
        $this->bhr->method('findByAccount')->willReturn([
            $this->balanceHistory(10, BalanceOperation::ADD),
            $this->balanceHistory(5, BalanceOperation::MINUS),
        ]);
        $dec = new SodiumDecrypt();
        $account = $this->account();
        $result = $this->action->sync($account);
        self::assertSame(5.0, (float) $dec->decrypt($result->balance));
    }

    /**
     * @covers \CryptoBank\Action\Account\SyncBalance::sync 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testValueOfSyncMinus(): void
    {
        $balance = $this->balance(value: 0);
        $this->br->method('findOneByAccount')->willReturn($balance);
        $this->br->method('update')->willReturnCallback(fn ($p) => $p);
        $this->bhr->method('findByAccount')->willReturn([
            $this->balanceHistory(10, BalanceOperation::ADD),
            $this->balanceHistory(15, BalanceOperation::MINUS),
        ]);
        $dec = new SodiumDecrypt();
        $account = $this->account();
        $result = $this->action->sync($account);
        self::assertSame(-5.0, (float) $dec->decrypt($result->balance));
    }

    /**
     * @covers \CryptoBank\Action\Account\SyncBalance::lastBalanceSync 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testLastSync(): void
    {
        $balance = $this->balance(value: 0);
        $this->br->method('findOneByAccount')->willReturn($balance);
        $this->br->method('update')->willReturnCallback(fn ($p) => $p);
        $dec = new SodiumDecrypt();
        $account = $this->account();
        $result = $this->action->lastBalanceSync($account, $this->balanceHistory(15, BalanceOperation::MINUS));
        self::assertSame(-15.0, (float) $dec->decrypt($result->balance));
    }
}
