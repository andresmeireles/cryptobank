<?php

namespace Cryptocli\Test\Utils;

use Cryptocli\Utils\SodiumDecrypt;
use Cryptocli\Utils\SodiumEncrypt;
use PHPUnit\Framework\TestCase;

class SodiumDecryptTest extends TestCase
{
    private SodiumDecrypt $decrypt;

    protected function setUp(): void
    {
        $this->decrypt = new SodiumDecrypt();
    }

    /**
     * @covers \Cryptocli\Utils\SodiumDecrypt::decrypt
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
}
