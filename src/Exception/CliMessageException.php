<?php

declare(strict_types=1);

namespace CryptoBank\Exception;

class CliMessageException extends \Exception
{
    public function __construct(
        public readonly string $errorMessage,
        public readonly CliExceptionWeight $cliExceptionWeight,
        string $message,
    ) {
        $this->message = $message;
   }
}
