<?php

declare(strict_types=1);

namespace CryptoBank\Errors;

interface Error
{
    public function message(): string;
}
