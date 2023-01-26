<?php

declare(strict_types=1);

namespace Cryptocli\Utils;

use Cryptocli\Utils\Api\EncryptInterface;

class SodiumEncrypt implements EncryptInterface
{
    public function encrypt(string $value): string
    {
        $key = $_ENV['SECRET_KEY'];
        $nonce = $_ENV['SECRET_NONCE'];
        return sodium_crypto_secretbox($value, $nonce, $key);
    }
}

