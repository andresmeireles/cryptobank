<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api;

interface CreateJwtInterface
{
    public function create(string $userName): string;
}
 
