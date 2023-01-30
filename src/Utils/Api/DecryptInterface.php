<?php

declare(strict_types=1);

namespace CryptoBank\Utils\Api;

interface DecryptInterface
{
    public function decrypt(string $value): string;
}
