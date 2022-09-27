<?php

namespace Test\Unit\Services\Auth;

use Cryptocli\Services\Auth\FirebaseJwt;
use PHPUnit\Framework\TestCase;

class FirebaseJwtTest extends TestCase
{
    private FirebaseJwt $firebaseJwt;

    protected function setUp(): void
    {
        $this->firebaseJwt = new FirebaseJwt('o', 'HS256');
    }

    public function testEncode(): void
    {
        $result = $this->firebaseJwt->encode(['user' => 1], 20);

        self::assertIsString($result);
    }

    public function testEncodeWithDefaultTimestamp(): void
    {
        $jwt = $this->firebaseJwt->encode(['user' => 1]);
        $time = (new \DateTime())->modify(sprintf('+%s seconds', 3600))->getTimestamp();
        $result = $this->firebaseJwt->decodeAsArray($jwt);

        self::assertSame($result['expiresAt'], $time);
    }

    public function testDecodeAsArray(): void
    {
        $token = ['user' => 1];
        $jwt = $this->firebaseJwt->encode($token, 30);
        $token = ['user' => 1, 'expiresAt' => (new \DateTime())->modify(sprintf('+%s seconds', 30))->getTimestamp()];
        $result = $this->firebaseJwt->decodeAsArray($jwt);

        self::assertSame($result, $token);
    }

    public function testDecodeAsStdClass(): void
    {
        $token = ['user' => 1];
        $stdClass = new \stdClass;
        $stdClass->user = 1;
        $stdClass->expiresAt = (new \DateTime())->modify(sprintf('+%s seconds', 30))->getTimestamp();
        $jwt = $this->firebaseJwt->encode($token, 30);
        $result = $this->firebaseJwt->decodeAsStdClass($jwt);

        self::assertSame([$result->user, $result->expiresAt], [$stdClass->user, $stdClass->expiresAt]);
    }
}
