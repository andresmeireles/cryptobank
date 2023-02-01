<?php

declare(strict_types=1);

namespace CryptoBank\Test;

use CryptoBank\Model\Auth;
use CryptoBank\Model\Jwt;
use CryptoBank\Model\User;
use PHPUnit\Framework\MockObject\MockObject;

trait Helper {
    public function user(int $id = 1): User|MockObject
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn($id);
        return $user;
    }

    public function auth(): Auth|MockObject
    {
        return $this->createMock(Auth::class);
    }

    public function jwt(): Jwt|MockObject
    {
        return $this->createMock(Jwt::class);
    }
}
