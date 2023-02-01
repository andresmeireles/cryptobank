<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action\Auth;

use CryptoBank\Action\Auth\CreateAuthUser;
use CryptoBank\Model\Account;
use CryptoBank\Model\Auth;
use CryptoBank\Model\User;
use CryptoBank\Repository\Api\AuthRepositoryInterface;
use CryptoBank\Test\Helper;
use PHPUnit\Framework\TestCase;

class CreateAuthUserTest extends TestCase
{
    use Helper;

    private CreateAuthUser $action;

    protected function setUp(): void
    {
        $ar = $this->createMock(AuthRepositoryInterface::class);
        $ar->method('create')->willReturn($this->auth());
        $this->action = new CreateAuthUser($ar);
    }

    /** 
     * @covers \CryptoBank\Action\Auth\CreateAuthUser::create 
     * @return void
     */
    public function testCreate(): void
    {
        $user = $this->user();
        $user->cnpjCpf = '22';
        $account = new Account();
        $result = $this->action->create($user, $account);
        self::assertIsObject($result);
    }
}
