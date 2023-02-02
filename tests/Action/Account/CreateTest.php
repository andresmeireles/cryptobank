<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action\Account;

use CryptoBank\Action\Account\Create;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;
use CryptoBank\Test\Helper;
use PHPUnit\Framework\MockObject\IncompatibleReturnValueException;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class CreateTest extends TestCase
{
    use Helper;

    private Create $action;

    protected function setUp(): void
    {
        $br = $this->createMock(BalanceRepositoryInterface::class);
        $this->action = new Create($br);
    }

    /**
     * @covers \CryptoBank\Action\Account\Create::create 
     * @throws IncompatibleReturnValueException 
     * @throws InvalidArgumentException 
     * @throws ExpectationFailedException 
     */
    public function testCreate(): void
    {
        $account = $this->account();
        $account->method('getId')->willReturn(1);
        $result = $this->action->create($account);
        self::assertIsObject($result);
    }
}
