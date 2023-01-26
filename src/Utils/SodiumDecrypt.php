<?php

declare(strict_types=1);

namespace Cryptocli\Utils;

use Cryptocli\Utils\Api\DecryptInterface;
use String;

class SodiumDecrypt implements DecryptInterface
{
    public function decrypt(String $value): String
    {
        $key = $_ENV['SECRET_KEY'];
        $nonce = $_ENV['SECRET_NONCE'];
        $decryptedMessage = sodium_crypto_secretbox_open($value, $key, $nonce);
        if (!$decryptedMessage) {
            throw new \LogicException('Error on decrypt message');
        }
        return $decryptedMessage;
    }
}
