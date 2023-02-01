<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api;

use CryptoBank\Model\DecryptedJwt;

interface ParseJwtInterface extends JwtInterface
{
    public function parse(string $jwt): DecryptedJwt;
}
