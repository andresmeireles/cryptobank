<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api;

interface CreateJwtInterface extends JwtInterface
{
    public function create(string $userName): string;
}
 
