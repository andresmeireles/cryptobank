<?php

declare(strict_types=1);

namespace CryptoBank\Utils\Api;

interface EncryptInterface
{
    public function encrypt(string $value): string;
}
