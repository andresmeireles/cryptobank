<?php

declare(strict_types=1);

namespace CryptoBank\Test;

use CryptoBank\Model\Auth;
use CryptoBank\Model\Jwt;
use CryptoBank\Model\User;
use PHPUnit\Framework\MockObject\MockObject;

trait Helper {
    public function user(): User|MockObject
    {
        return $this->createMock(User::class);
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