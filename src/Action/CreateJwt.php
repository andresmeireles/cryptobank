<?php

declare(strict_types=1);

namespace CryptoBank\Action;

use CryptoBank\Action\Api\CreateJwtInterface;
use Firebase\JWT\JWT;

class CreateJwt implements CreateJwtInterface
{
    public function create(String $userName): string
    {
        return $this->issueToken($userName);
    }
    
    private function issueToken(string $userName): string
    { 
        $key = $_ENV['JWT_KEY'];
       $tokenData = [
            'iss' => 'andre',
            'aud' => 'andre',
            'uid' => $userName,
        ];
        return JWT::encode($tokenData, $key, self::ALGORITHM);
    }
}

