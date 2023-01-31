<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action;

use CryptoBank\Action\CreateJwt;
use PHPUnit\Framework\TestCase;

class CreateJwtTest extends TestCase
{
    private CreateJwt $createJwt;

    protected function setUp(): void
    {
        $this->createJwt = new CreateJwt();
    }

    /**
    * @covers \CryptoBank\Action\CreateJwt::create
    */
    public function testCreate(): void
    {
        $result = $this->createJwt->create('message');
        self::assertIsString($result);
    }
}
