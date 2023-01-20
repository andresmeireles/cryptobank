<?php

declare(strict_types=1);

namespace Cryptocli\Utils\Api;

use Monolog\Level;
use Monolog\Logger;

interface CrytoLoggerInterface
{
    public function createLogger(string $name, ?Level $level = null): Logger;

    public function warning(string $log): void;

    public function error(string $log): void;

    public function info(string $log): void;
}