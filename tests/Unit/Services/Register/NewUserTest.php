<?php

declare(strict_types=1);

namespace Test\Unit\Services\Register;

use Cryptocli\DTO\CreateUser;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\Register\NewUser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NewUserTest extends TestCase
{
    private NewUser $newUser;
    private MockObject $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        $this->newUser = new NewUser($this->userRepository);
    }

    /**
     * @covers \Cryptocli\Services\Register\NewUser::create
     */
    public function testCreate(): void
    {
        $userData = new CreateUser(
            nameCommercialName: 'André Meireles',
            cnpjCpf: '101010101',
            rgIE: '1010101',
            dataNascimentoDataFundacao: \DateTime::createFromImmutable(new \DateTimeImmutable()),
            phone: '101010101',
            address: 'rua x'
        );
        $this->userRepository->method('create')->willReturn($userData->toUser());

        $result = $this->newUser->create($userData);

        self::assertInstanceOf(User::class, $result);
    }
}
