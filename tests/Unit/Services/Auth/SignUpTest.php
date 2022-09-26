<?php

namespace Test\Unit\Services\Auth;

use Cryptocli\Model\Auth;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\AuthRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\Auth\SignUp;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SignUpTest extends TestCase
{
    private SignUp $service;
    private MockObject $authRepository;
    private MockObject $userRepository;

    protected function setUp(): void
    {
        $this->authRepository = $this->createMock(AuthRepository::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $this->service = new SignUp(
            $this->authRepository,
            $this->userRepository,
            $logger
        );

        parent::setUp();
    }

    public function testCreateSignUp(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);
        $this->userRepository->method('find')->willReturn($user);
        $this->authRepository->method('create')->willReturnCallback(fn ($a) => $a);
        $result = $this->service->createSignUp(1, '123');

        self::assertInstanceOf(Auth::class, $result);
    }

    public function testPassword(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);
        $this->userRepository->method('find')->willReturn($user);
        $this->authRepository->method('create')->willReturnCallback(fn ($a) => $a);
        $auth = $this->service->createSignUp(1, '123');
        $result = password_verify('123', $auth->password);

        self::assertTrue($result);
    }
}
