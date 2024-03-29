<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action\Auth;

use CryptoBank\Action\ActionErrors;
use CryptoBank\Action\Api\Auth\CreateAuthUserInterface;
use CryptoBank\Action\CreateJwt;
use CryptoBank\Action\Auth\CreateUser;
use CryptoBank\Model\Account;
use CryptoBank\Model\User;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\JwtRepositoryInterface;
use CryptoBank\Repository\Api\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    private CreateUser $createUser;

    protected function setUp(): void
    {
        $ar = $this->createMock(AccountRepositoryInterface::class);
        $ur = $this->createMock(UserRepositoryInterface::class);
        $jr = $this->createMock(JwtRepositoryInterface::class);
        $cau = $this->createMock(CreateAuthUserInterface::class);
        $user = new User();
        $account = new Account();
        $user->name = 'Andre';
        $ur->method('create')->willReturn($user);
        $ar->method('create')->willReturn($account);
        $cj = new CreateJwt();
        $this->createUser = new CreateUser($ur, $ar, $jr, $cau, $cj);
    }

    /**
     * @covers \CryptoBank\Action\CreateUser::create
     */
    public function testCreateUser(): void
    {
        $result = $this->createUser->create('andre', '53936047006', '22', '2010-05-09', '981151212', 'email@email.com');
        self::assertIsString($result);
    }

    /**
     * @covers \CryptoBank\Action\CreateUser::create
     */
    public function testCreateUserInvalidName(): void
    {
        $result = $this->createUser->create('andre', '1212', '22', '2010-05-09', '981151212', 'email@email.com');
        self::assertSame(ActionErrors::INVALID_CPF_CNPJ, $result);
    }
    /**
     * @covers \CryptoBank\Action\CreateUser::validate
     */
    public function testValidationName(): void
    {
        $result = $this->createUser->validate(' ', '53936047006', '22', '2010-05-09', '981151212', 'email@email.com');
        self::assertSame(ActionErrors::INVALID_NAME, $result);
    }

    /**
     * @covers \CryptoBank\Action\CreateUser::validate
     */
    public function testValidationCpf(): void
    {
        $result = $this->createUser->validate('Andre', '121212', '22', '2010-05-09', '981151212', 'email@email.com');
        self::assertSame(ActionErrors::INVALID_CPF_CNPJ, $result);
    }

    /**
     * @covers \CryptoBank\Action\CreateUser::validate
     */
    public function testValidationDate(): void
    {
        $result = $this->createUser->validate('Andre', '53936047006', '22', '2010-22-09', '981151212', 'email@email.com');
        self::assertSame(ActionErrors::INVALID_DATE, $result);
    }

    /**
     * @covers \CryptoBank\Action\CreateUser::validate
     */
    public function testValidationPhone(): void
    {
        $result = $this->createUser->validate('Andre', '53936047006', '22', '2010-05-09', '1212', 'email@email.com');
        self::assertSame(ActionErrors::INVALID_PHONE, $result);
    }

    /**
     * @covers \CryptoBank\Action\CreateUser::validate
     */
    public function testValidationEmail(): void
    {
        $result = $this->createUser->validate('Andre', '53936047006', '22', '2010-05-09', '981151212', ' ');
        self::assertSame(ActionErrors::INVALID_ADDRESS, $result);
    }

    /**
     * @covers \CryptoBank\Action\CreateUser::validate
     */
    public function testValidationRg(): void
    {
        $result = $this->createUser->validate('Andre', '53936047006', '', '2010-05-09', '981151212', 'emailemail.com');
        self::assertSame(ActionErrors::INVALID_RG, $result);
    }
}
