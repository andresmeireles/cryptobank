<?php

declare(strict_types=1);

namespace CryptoBank\Utils\Api;

use Monolog\Level;
use Monolog\Logger;

interface CryptoLoggerInterface
{
    public function createLogger(string $name, ?Level $level = null): Logger;

    public function warning(string $log): void;

    public function error(string $log): void;

    public function info(string $log): void;
}