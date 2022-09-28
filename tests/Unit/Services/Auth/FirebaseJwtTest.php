<?php

namespace Test\Unit\Services\Auth;

use Cryptocli\Services\Auth\FirebaseJwt;
use Cryptocli\Services\Auth\JwtPayload;
use PHPUnit\Framework\TestCase;

class FirebaseJwtTest extends TestCase
{
    private FirebaseJwt $firebaseJwt;

    protected function setUp(): void
    {
        $this->firebaseJwt = new FirebaseJwt('o', 'HS256');
    }

    /**
     * @covers \Cryptocli\Services\Auth\FirebaseJwt::encode
     */
    public function testEncode(): void
    {
        $result = $this->firebaseJwt->encode(new JwtPayload(1));

        self::assertIsString($result);
    }

    /**
     * @covers \Cryptocli\Services\Auth\FirebaseJwt::decode
     * @covers \Cryptocli\Services\Auth\FirebaseJwt::encode
     */
    public function testEncodeWithDefaultTimestamp(): void
    {
        $jwt = $this->firebaseJwt->encode(new JwtPayload(1));
        $time = (new \DateTime())->modify(sprintf('+%s seconds', 3600))->getTimestamp();
        $result = $this->firebaseJwt->decode($jwt);

        self::assertSame($result->expiresAt->getTimestamp(), $time);
    }

    /**
     * @covers \Cryptocli\Services\Auth\FirebaseJwt::decode
     * @covers \Cryptocli\Services\Auth\FirebaseJwt::encode
     */
    public function testDecode(): void
    {
        $jwt = $this->firebaseJwt->encode(new JwtPayload(1));
        $result = $this->firebaseJwt->decode($jwt);

        self::assertInstanceOf(JwtPayload::class, $result);
    }

    /**
     * @covers \Cryptocli\Services\Auth\FirebaseJwt::decode
     */
    public function testDecodeArray(): void
    {
        $payload = new JwtPayload(1);
        $jwt = $this->firebaseJwt->encode($payload);
        $result = $this->firebaseJwt->decode($jwt);

        self::assertSame($result->toArray(), $payload->toArray());
    }
}
