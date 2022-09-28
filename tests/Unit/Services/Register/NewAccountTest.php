<?php

namespace Test\Unit\Services\Register;

use Cryptocli\Model\Account;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\AccountRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\Register\CreateAccount;
use Cryptocli\Services\Register\NewAccount;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class NewAccountTest extends TestCase
{
    private CreateAccount $createAccount;
    private MockObject $accountRepository;
    private MockObject $userRepository;

    protected function setUp(): void
    {
        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->createAccount = new NewAccount($this->accountRepository, $this->userRepository, $this->createMock(LoggerInterface::class));
    }

    /**
     * @covers \Cryptocli\Services\Register\NewAccount::create
     */
    public function testCreate(): void
    {
        $user = User::create('a', 'a', 'a', new \DateTime(), 'q', 'q');
        $this->userRepository->method('find')->willReturn($user);
        $this->accountRepository->method('create')->willReturn(Account::create($user));
        $this->accountRepository->method('findBy')->willReturn([]);
        $result = $this->createAccount->create(1);

        self::assertInstanceOf(Account::class, $result);
    }

    /**
     * @covers \Cryptocli\Services\Register\NewAccount::create
     */
    public function testTwoNumbersAccont(): void
    {
        $user = User::create('a', 'a', 'a', new \DateTime(), 'q', 'q');
        $validAccount = Account::create($user);
        $this->userRepository->method('find')->willReturn($user);
        $this->accountRepository->method('create')->willReturnCallback(fn ($a) => $a);
        $this->accountRepository->method('findBy')->willReturnCallback(fn ($a) => $a === $validAccount->number ? $validAccount : []);
        $result = $this->createAccount->create(1);

        self::assertNotEquals($validAccount->number, $result->number);
    }
}
