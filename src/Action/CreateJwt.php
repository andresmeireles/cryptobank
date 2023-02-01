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
        $dateTime = new \DateTimeImmutable();
        $key = $_ENV['JWT_KEY'];
       $tokenData = [
            'iss' => 'andre',
            'aud' => 'andre',
            'uid' => $userName,
            'iat' => $dateTime->getTimestamp(), // issued at
            'eat' => $dateTime->add(new \DateInterval('P1D'))->getTimestamp(), // expires at
        ];
        return JWT::encode($tokenData, $key, self::ALGORITHM);
    }
}

