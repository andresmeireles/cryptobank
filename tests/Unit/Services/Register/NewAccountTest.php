<?php

namespace Test\Unit\Services\Register;

use Cryptocli\Repository\Interfaces\AccountRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\Register\CreateAccount;
use Cryptocli\Services\Register\NewAccount;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NewAccountTest extends TestCase
{
    private CreateAccount $createAccount;
    private MockObject $accountRepository;
    private MockObject $userRepository;

    protected function setUp(): void
    {
        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->createAccount = new NewAccount($this->accountRepository, $this->userRepository);
    }

    public function testCreate(): void
    {

    }
}
