<?php

declare(strict_types=1);

namespace CryptoBank\Model;

class DecryptedJwt
{
    private function __construct(
        public readonly string $issuedBy,
        public readonly string $aud,
        public readonly string $uid,
        public readonly int $issuedAt,
        public readonly int $expiresAt,
    ) {
    }

    public static function create(object $object): self
    {
        return new self($object->iss, $object->aud, $object->uid, $object->iat, $object->eat);
    }

    public function isValid(): bool
    {
        return $this->expiresAt < (new \DateTimeImmutable())->getTimestamp();     
    } 
}
