<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

use Firebase\JWT\JWT as JWTFirebase;
use Firebase\JWT\Key;

class FirebaseJwt implements Jwt
{
    public function __construct(
        private readonly string $key,
        private readonly string $algo
    )
    {
    }

    public function encode(JwtPayload $payload, int $expiresAt = 3600): string
    {
        return JWTFirebase::encode($payload->toArray(), $this->key, $this->algo);
    }

    public function decode(string $jwt): JwtPayload
    {
        $payload = JWTFirebase::decode($jwt, new Key($this->key, $this->algo));
        if ($payload->user === null || $payload->expiresAt === null) {
            throw new \InvalidArgumentException('invalid jwt');
        }
        $timestampToDateTime = (new \DateTime())->setTimestamp($payload->expiresAt);

        return new JwtPayload($payload->user, $timestampToDateTime);
    }
}