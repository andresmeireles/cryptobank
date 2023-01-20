<?php

declare(strict_types=1);

namespace Cryptocli\Action;

use Cryptocli\Action\Api\CreateJwtInterface;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class CreateJwt implements CreateJwtInterface
{
    public function create(String $userName): string
    {
        return $this->issueToken($userName);
    }
    
    private function issueToken(string $userName): string
    {
        $builder = new Builder(new JoseEncoder(), new ChainedFormatter());
        $algo = new Sha256();
        $signkey = InMemory::plainText(random_bytes(32));
        $now = new \DateTimeImmutable();
        $token = $builder
            ->issuedBy('me')
            ->permittedFor('user')
            ->identifiedBy($userName)
            ->issuedAt($now)
            ->getToken($algo, $signkey);
        return $token->toString();
    }
}

