<?php

declare(strict_types=1);

namespace CryptoBank\Action;

use CryptoBank\Action\Api\ParseJwtInterface;
use CryptoBank\Model\DecryptedJwt;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ParseJwt implements ParseJwtInterface
{
    public function parse(string $jwt): DecryptedJwt
    {
        try {
            $token = JWT::decode($jwt, new Key($_ENV['JWT_KEY'], self::ALGORITHM));
            return DecryptedJwt::create($token);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
