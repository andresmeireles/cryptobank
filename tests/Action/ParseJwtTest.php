<?php

declare(strict_types=1);

namespace CryptoBank\Test\Action;

use CryptoBank\Action\CreateJwt;
use CryptoBank\Action\ParseJwt;
use PHPUnit\Framework\TestCase;

class ParseJwtTest extends TestCase
{
    private ParseJwt $parser;

    protected function setUp(): void
    {
        $this->parser = new ParseJwt();
    }

    /**
     * @covers \CryptoBank\Action\ParseJwt::parse
     * @return void
     */
    public function testParse(): void
    {
        $str = (new CreateJwt())->create('jose');
        $result = $this->parser->parse($str);
        self::assertIsString($result->uid);
    }

    /**
    * @covers \CryptoBank\Action\ParseJwt::parse
    */
    public function testError(): void
    {
        $str = (new CreateJwt())->create('');
        $result = $this->parser->parse($str);
        self::assertSame('', $result->uid);
    }
}
