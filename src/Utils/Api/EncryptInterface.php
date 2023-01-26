<?php

declare(strict_types=1);

namespace Cryptocli\Utils\Api;

interface EncryptInterface
{
    public function encrypt(string $value): string;
}
