<?php

namespace CryptoBank\Cli;

use CryptoBank\Cli\Commands\AddCustomer;
use CryptoBank\Cli\Commands\Message;

class Commands
{
    private const COMMAND_NAMESPACE = "CryptoBank\\Cli\\Commands\\";

    /**
     * @return class-string[]|string[]
     */
    public function getSymfonyCommands(): array
    {
        $commandDir = __DIR__ . '/../Cli/Commands';
        $commandFiles = array_diff(scandir($commandDir), ['.', '..']);;
        return array_map(static function (string $file) {
            $className = substr($file, 0, strpos($file, '.'));
            return sprintf('%s%s', self::COMMAND_NAMESPACE, $className);
        }, $commandFiles);
    }
}