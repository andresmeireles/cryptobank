<?php

declare(strict_types=1);

namespace Cryptocli\Utils\Api;

interface DecryptInterface
{
    public function decrypt(string $value): string;
}
