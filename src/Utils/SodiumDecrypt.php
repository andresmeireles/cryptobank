<?php

declare(strict_types=1);

namespace Cryptocli\Utils;

use Cryptocli\Utils\Api\DecryptInterface;

class SodiumDecrypt implements DecryptInterface
{
    public function decrypt(string $value): string
    {
        $key = hex2bin($_ENV['SECRET_KEY']);
        $nonce = hex2bin($_ENV['SECRET_NONCE']);
        $decryptedMessage = sodium_crypto_secretbox_open($value, $nonce, $key);
        if (!$decryptedMessage) {
            throw new \LogicException('Error on decrypt message');
        }
        return $decryptedMessage;
    }
}
