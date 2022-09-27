<?php

namespace Cryptocli\Services\Auth;

interface Jwt
{
    /**
     * @param string[] $payload
     */
    public function encode(array $payload, int $expiresAt = 3600): string;

    public function decodeAsArray(string $jwt): array;

    public function decodeAsStdClass(string $jwt): \stdClass;
}