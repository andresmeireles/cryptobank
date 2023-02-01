<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action\Auth;

use CryptoBank\Test\Helper;
use CryptoBank\Action\Auth\AuthError;
use CryptoBank\Action\Auth\SignIn;
use CryptoBank\Model\Account;
use CryptoBank\Model\User;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\AuthRepositoryInterface;
use CryptoBank\Repository\Api\JwtRepositoryInterface;
use CryptoBank\Repository\Api\UserRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SignInTest extends TestCase 
{
    use Helper;

    private SignIn $signIn;
    private AccountRepositoryInterface|MockObject $accr;
    private UserRepositoryInterface|MockObject $usr;
    private AuthRepositoryInterface|MockObject $aur;
    private AuthRepositoryInterface|MockObject $jwtr;

    protected function setUp(): void
    {
        $this->accr = $this->createMock(AccountRepositoryInterface::class);
        $this->jwtr = $this->createMock(JwtRepositoryInterface::class);
        $this->usr = $this->createMock(UserRepositoryInterface::class);
        $this->aur = $this->createMock(AuthRepositoryInterface::class);
        $this->signIn = new SignIn(
            authRepository: $this->aur,
            userRepository: $this->usr,
            jwtRepository: $this->jwtr,
            accountRepository: $this->accr, 
        );
    }

    /**
     * @covers \CryptoBank\Action\Auth\SignIn::withJwt
     * @return void
     */
    public function testWithJwtError(): void
    {
        $this->accr->method('find')->willReturn(null);
        $this->usr->method('findOneUserByName')->willReturn(null);
        $result = $this->signIn->withJwt('e44x');
        self::assertSame(AuthError::INVALID_JWT, $result);
    }

     /**
     * @covers \CryptoBank\Action\Auth\SignIn::withJwt
     * @return void
     */
    public function testWithJwt(): void
    {
        $user = $this->user();
        $jwt = $this->jwt();
        $jwt->user = $user;
        $this->jwtr->method('getByJwt')->willReturn($jwt);
        $result = $this->signIn->withJwt('e44x');
        self::assertIsObject($result);
    }

    /**
     * @covers \CryptoBank\Action\Auth\SignIn::withPassword
     * @return void
     */
    public function testWithPassword(): void
    {
        $user = $this->user();
        $auth = $this->auth();
        $auth->password = password_hash('pass', PASSWORD_DEFAULT);
        $auth->user = $user;
        $user->name = 'Jose';
        $user->method('getId')->willReturn(1);
        $this->accr->method('find')->willReturn(new Account());
        $this->usr->method('findOneUserByName')->willReturn($user);
        $this->aur->method('getByUserId')->willReturn($auth);
        $result = $this->signIn->withPassword('user', 'pass');
        self::assertIsObject($result);
    }

    /**
     * @covers \CryptoBank\Action\Auth\SignIn::withPassword
     * @return void
     */
    public function testWithWrongPassword(): void
    {
        $user = $this->user();
        $auth = $this->auth();
        $auth->password = password_hash('pass', PASSWORD_DEFAULT);
        $auth->user = $user;
        $user->name = 'Jose';
        $user->method('getId')->willReturn(1);
        $this->accr->method('find')->willReturn(new Account());
        $this->usr->method('findOneUserByName')->willReturn($user);
        $this->aur->method('getByUserId')->willReturn($auth);
        $result = $this->signIn->withPassword('user', 'passed');
        self::assertSame(AuthError::INVALID_USER, $result);
    }
}
