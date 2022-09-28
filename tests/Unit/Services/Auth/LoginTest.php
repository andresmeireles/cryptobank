<?php

namespace Test\Unit\Services\Auth;

use Cryptocli\Model\Auth;
use Cryptocli\Model\AuthToken;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\AuthTokenRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\Auth\Jwt;
use Cryptocli\Services\Auth\Login;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoginTest extends TestCase
{
    private Login $login;
    private UserRepositoryInterface $user;
    private AuthTokenRepository $authTokenRepository;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->login = new Login(
            $this->createMock(Jwt::class),
            $this->user = $this->createMock(UserRepositoryInterface::class),
            $this->authTokenRepository = $this->createMock(AuthTokenRepository::class),
            $this->createMock(LoggerInterface::class),
        );
    }

    /**
     * @covers Login::withUserAndPassword
     */
    public function testWithUserAndPassword()
    {
        $user = $this->createMock(User::class);
        $user->auth = Auth::create($user, password_hash('123', PASSWORD_ARGON2I));
        $user->method('getId')->willReturn(1);
        $this->user->method('findOneBy')->willReturn($user);
        $this->authTokenRepository->method('findBy')->willReturn([]);
        $this->authTokenRepository->method('create')->willReturnCallback(fn ($a) => $a);
        $at = $this->login->withUserAndPassword(1, '123');

        self::assertInstanceOf(AuthToken::class, $at);
    }

    /**
     * @covers Login::withUserAndPassword
     */
    public function testAuthToken()
    {
        $user = $this->createMock(User::class);
        $user->auth = Auth::create($user, password_hash('123', PASSWORD_ARGON2I));
        $user->method('getId')->willReturn(1);
        $this->user->method('findOneBy')->willReturn($user);
        $this->authTokenRepository->method('findBy')->willReturn([]);
        $this->authTokenRepository->method('create')->willReturnCallback(fn ($a) => $a);
        $result = $this->login->withUserAndPassword(1, '123');

        self::assertIsString($result->token);
    }
}
