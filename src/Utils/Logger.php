<?php

declare(strict_types=1);

namespace CryptoBank\Utils;

use CryptoBank\Utils\Api\CryptoLoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as MonoLogger;

class Logger implements CryptoLoggerInterface
{
    private const LOGGER_PATH = __DIR__ . '/../../var/log';
    public function createLogger(string $name, ?Level $level = null): MonoLogger
    {
        $log = new MonoLogger($name);
        $log->pushHandler(new StreamHandler(self::LOGGER_PATH, $level ?? Level::Info));
        return $log;
    }

    public function getLog(): MonoLogger
    {
        return $this->createLogger('log');
    }

    public function warning(string $log): void
    {
        $this->getLog()->warning($log);
    }

    public function error(string $log): void
    {
        $this->getLog()->error($log);
    }

    public function info(string $log): void
    {
        $this->getLog()->info($log);
    }
}