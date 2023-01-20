<?php

declare(strict_types=1);

use Cryptocli\Action\Api\CreateJwtInterface;
use Cryptocli\Action\Api\CreateUserInterface;
use Cryptocli\Action\CreateJwt;
use Cryptocli\Action\CreateUser;
use Cryptocli\Cli\Cli;
use Cryptocli\Cli\SymfonyCli;
use Cryptocli\Repository\AccountRepository;
use Cryptocli\Repository\Api\AccountRepositoryInterface;
use Cryptocli\Repository\Api\UserRepositoryInterface;
use Cryptocli\Repository\UserRepository;
use Cryptocli\Utils\Api\CrytoLoggerInterface;
use Cryptocli\Utils\Logger;
use DI\Container;
use Doctrine\ORM\EntityManagerInterface;

return array(
    Cli::class => static function (Container $container) {
        $commands = new Cryptocli\Cli\Commands();
        return new SymfonyCli($container, $commands->getSymfonyCommands());
    },
    EntityManagerInterface::class => function () {
        require __DIR__ . '/../bootstrap/doctrine_bootstrap.php';
        return $entityManager;
    },
    // actions
    CreateUserInterface::class => static fn (Container $c) => $c->get(CreateUser::class),
    CreateJwtInterface::class => static fn () => new CreateJwt(),
    // other
    CrytoLoggerInterface::class => static fn () => new Logger(),
    // repositories
    UserRepositoryInterface::class => static fn (Container $c) => new UserRepository($c->get(EntityManagerInterface::class)),
    AccountRepositoryInterface::class => static fn (Container $c) => new AccountRepository($c->get(EntityManagerInterface::class)),
);
