<?php

namespace Cryptocli\Services\Auth;

interface Jwt
{
    public function encode(JwtPayload $payload, int $expiresAt = 3600): string;

    public function decode(string $jwt): JwtPayload;
}