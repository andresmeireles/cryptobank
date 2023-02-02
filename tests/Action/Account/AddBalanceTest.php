<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action\Account;

use CryptoBank\Action\Account\AddBalance;
use CryptoBank\Dto\BalanceOperation;
use CryptoBank\Repository\Api\BalanceHistoryRepositoryInterface;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;
use CryptoBank\Test\Helper;
use PHPUnit\Framework\MockObject\IncompatibleReturnValueException;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class AddBalanceTest extends TestCase
{
    use Helper;

    private AddBalance $action;

    protected function setUp(): void
    {
        $bhr = $this->createMock(BalanceHistoryRepositoryInterface::class);
        $br = $this->createMock(BalanceRepositoryInterface::class);
        $br->method('findOneByAccount')->willReturn($this->balance());
        $this->action = new AddBalance($bhr, $br);
    }

    /**
     * @covers \CryptoBank\Action\Account\AddBalance::add 
     * @throws IncompatibleReturnValueException 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testAddBalance(): void
    {
        $account = $this->account();
        $account->method('getId')->willReturn(1);
        $result = $this->action->add($account, 22, BalanceOperation::ADD);
        self::assertIsObject($result);
    }
}
