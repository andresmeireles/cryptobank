<?php

declare(strict_types=1);

namespace CryptoBank\Exception;

use CryptoBank\Errors\Error;

class CliException extends \Exception
{
    public function __construct(public readonly Error $error, string $message)
    {
        parent::__construct($message);
    }     
}
