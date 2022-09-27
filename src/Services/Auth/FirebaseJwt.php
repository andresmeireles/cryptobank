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

    /**
     * @inheritDoc
     */
    public function encode(array $payload, int $expiresAt = 3600): string
    {
        $payload['expiresAt'] = (new \DateTimeImmutable())->modify(sprintf('+%s seconds', $expiresAt))->getTimestamp();

        return JWTFirebase::encode($payload, $this->key, $this->algo);
    }

    public function decodeAsStdClass(string $jwt): \stdClass
    {
        return JWTFirebase::decode($jwt, new Key($this->key, $this->algo));
    }

    public function decodeAsArray(string $jwt): array
    {
        $decode = $this->decodeAsStdClass($jwt);

        return (array) $decode;
    }
}