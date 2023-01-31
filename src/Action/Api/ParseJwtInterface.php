<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api;

interface ParseJwtInterface extends JwtInterface
{
    public function parse(string $jwt): object;
}
