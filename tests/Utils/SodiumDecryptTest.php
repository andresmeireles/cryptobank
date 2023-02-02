<?php

declare(strict_types=1);

namespace CryptoBank\Test\Utils;

use CryptoBank\Utils\SodiumDecrypt;
use CryptoBank\Utils\SodiumEncrypt;
use PHPUnit\Framework\TestCase;

class SodiumDecryptTest extends TestCase
{
    private SodiumDecrypt $decrypt;

    protected function setUp(): void
    {
        $this->decrypt = new SodiumDecrypt();
    }

    /**
     * @covers \CryptoBank\Utils\SodiumDecrypt::decrypt
     */
    public function testDecrypt(): void
    {
        $message = 'text to encrypt';
        $_ENV['SECRET_KEY'] = bin2hex(random_bytes(32));
        $_ENV['SECRET_NONCE'] = bin2hex(random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES));
        $encrypt = (new SodiumEncrypt())->encrypt($message);
        $result = $this->decrypt->decrypt($encrypt);
        self::assertSame($message, $result);
    }
    
    /**
     * @covers \CryptoBank\Utils\SodiumDecrypt::decrypt
     */
    public function testDecryptZero(): void
    {
        $message = "0";
        $encrypt = (new SodiumEncrypt())->encrypt($message);
        $result = $this->decrypt->decrypt($encrypt);
        self::assertSame($message, $result);
    }
}
