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
        if (!is_dir(self::LOGGER_PATH)) {
            mkdir(self::LOGGER_PATH);
        }
        $fileName = sprintf('%s/%s.log', self::LOGGER_PATH, $name);
        $log->pushHandler(new StreamHandler($fileName, $level ?? Level::Info));
        return $log;
    }

    public function getLog(string $logName): MonoLogger
    {
        return $this->createLogger($logName);
    }

    public function warning(string $log): void
    {
        $this->getLog(self::WARNING_DIR)->warning($log);
    }

    public function error(string $log): void
    {
        $this->getLog(self::ERROR_DIR)->error($log);
    }

    public function info(string $log): void
    {
        $this->getLog(self::INFO_DIR)->info($log);
    }
}
