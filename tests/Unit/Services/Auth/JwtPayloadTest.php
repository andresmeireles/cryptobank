<?php

declare(strict_types=1);

namespace Test\Unit\Services\Auth;

use Cryptocli\Services\Auth\JwtPayload;
use PHPUnit\Framework\TestCase;

class JwtPayloadTest extends TestCase
{
    /**
     * @covers \Cryptocli\Services\Auth\JwtPayload::toArray
     */
    public function testToArray()
    {
        $jwtPayload = new JwtPayload(1);
        $toArray = $jwtPayload->toArray();

        self::assertIsArray($toArray);
    }

    /**
     * @covers \Cryptocli\Services\Auth\JwtPayload::toArray
     */
    public function testToArrayValues()
    {
        $valitUntil = new \DateTime('2022-10-31');

        $jwtPayload = new JwtPayload(1, $valitUntil);
        $toArray = $jwtPayload->toArray();

        self::assertSame($toArray, ['user' => 1, 'expiresAt' => $valitUntil->getTimestamp()]);
    }

    /**
     * @covers \Cryptocli\Services\Auth\JwtPayload::isExpired
     */
    public function testIsExpired()
    {
        $valitUntil = new \DateTime('2022-10-31');
        $jwtPayload = new JwtPayload(1, $valitUntil);

        self::assertFalse($jwtPayload->isExpired());
    }

    /**
     * @covers JwtPayload::isExpired
     */
    public function testIsNotExpired()
    {
        $valitUntil = new \DateTime('2020-10-31');
        $jwtPayload = new JwtPayload(1, $valitUntil);

        self::assertTrue($jwtPayload->isExpired());
    }
}
