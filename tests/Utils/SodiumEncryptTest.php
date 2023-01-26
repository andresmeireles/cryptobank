<?php

declare(strict_types=1);

namespace Cryptocli\Test\Utils;

use Cryptocli\Utils\SodiumEncrypt;
use PHPUnit\Framework\TestCase;

class SodiumEncryptTest extends TestCase
{
    private SodiumEncrypt $encrypt;

    protected function setUp(): void
    {
        $this->encrypt = new SodiumEncrypt();
    }

    public function testEncrypt(): void
    {
        $_ENV['SECRET_KEY'] = '2';
        $_ENV['SECRET_NONCE'] = '2';
        $result = $this->encrypt->encrypt('message');
        self::assertIsString($result);
    }
}
