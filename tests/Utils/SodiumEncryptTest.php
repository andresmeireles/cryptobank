<?php

declare(strict_types=1);

namespace CryptoBank\Test\Utils;

use CryptoBank\Utils\SodiumEncrypt;
use PHPUnit\Framework\TestCase;

class SodiumEncryptTest extends TestCase
{
    private SodiumEncrypt $encrypt;

    protected function setUp(): void
    {
        $this->encrypt = new SodiumEncrypt();
    }
     
    /**
     * @covers \CryptoBank\Utils\SodiumEncrypt::encrypt
     */
    public function testEncrypt(): void
    {
        $_ENV['SECRET_KEY'] = '4511133787b3af85624008ca00da158aa09c9797075f4f9a63efa6ef93378431';
        $_ENV['SECRET_NONCE'] = bin2hex(random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES));
        $result = $this->encrypt->encrypt('message');
        self::assertIsString($result);
    }
}
