<?php

declare(strict_types=1);

use CryptoBank\Action\Api\CreateJwtInterface;
use CryptoBank\Action\Api\CreateUserInterface;
use CryptoBank\Action\Auth\CreateUser;
use CryptoBank\Action\CreateJwt;
use CryptoBank\Cli\Cli;
use CryptoBank\Cli\SymfonyCli;
use CryptoBank\Repository\AccountRepository;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\JwtRepositoryInterface;
use CryptoBank\Repository\Api\UserRepositoryInterface;
use CryptoBank\Repository\JwtRepository;
use CryptoBank\Repository\UserRepository;
use CryptoBank\Utils\Api\CryptoLoggerInterface;
use CryptoBank\Utils\Api\EncryptInterface;
use CryptoBank\Utils\Logger;
use CryptoBank\Utils\SodiumEncrypt;
use DI\Container;
use Doctrine\ORM\EntityManagerInterface;

return array(
    Cli::class => static function (Container $container) {
        $commands = new CryptoBank\Cli\Commands();
        return new SymfonyCli($container, $commands->getSymfonyCommands());
    },
    EntityManagerInterface::class => static fn () => require __DIR__ . '/../bootstrap/doctrine_bootstrap.php',
    // actions
    CreateUserInterface::class => static fn (Container $c) => $c->get(CreateUser::class),
    CreateJwtInterface::class => static fn () => new CreateJwt(),
    EncryptInterface::class => static fn () => new SodiumEncrypt(),
    // other
    CryptoLoggerInterface::class => static fn () => new Logger(),
    // repositories
    UserRepositoryInterface::class => static fn (Container $c) => new UserRepository($c->get(EntityManagerInterface::class)),
    AccountRepositoryInterface::class => static fn (Container $c) => new AccountRepository($c->get(EntityManagerInterface::class)),
    JwtRepositoryInterface::class => static fn(Container $c) => new JwtRepository($c->get(EntityManagerInterface::class)),
);
