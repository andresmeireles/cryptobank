<?php

declare(strict_types=1);

use Cryptocli\Cli\Cli;
use Cryptocli\Cli\Command\CreateUser;
use Cryptocli\Cli\Command\ListUsers;
use Cryptocli\Cli\SymfonyCli;
use Cryptocli\Repository\Interfaces\AccountRepository;
use Cryptocli\Repository\Interfaces\AuthRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Repository\UserRepository;
use Cryptocli\Services\Auth\SignUp;
use Cryptocli\Services\Auth\SignUpTypes;
use Cryptocli\Services\Register\CreateAccount;
use Cryptocli\Services\Register\CreateNewUser;
use Cryptocli\Services\Register\NewAccount;
use Cryptocli\Services\Register\NewUser;
use DI\Container;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return [
    EntityManagerInterface::class => fn() => require __DIR__ . '/../bootstrap/doctrine_bootstrap.php',
    Cli::class => function (Container $container) {
        $commands = [
            CreateUser::class,
            ListUsers::class
        ];
        return new SymfonyCli($container, $commands);
    },
    LoggerInterface::class => function () {
        $log = new Logger('system');
        $log->pushHandler(new StreamHandler(__DIR__ . '/../var/log/system.log', Level::Info));

        return $log;
    },
    AccountRepository::class => fn(Container $container) => new \Cryptocli\Repository\AccountRepository($container->get(EntityManagerInterface::class)),
    UserRepositoryInterface::class => fn (Container $container) => new UserRepository($container->get(EntityManagerInterface::class)),
    AuthRepository::class => fn (Container $container) => new \Cryptocli\Repository\AuthRepository($container->get(EntityManagerInterface::class)),
    CreateNewUser::class => fn (Container $container) => $container->get(NewUser::class),
    CreateAccount::class => fn (Container $container) => $container->get(NewAccount::class),
    SignUpTypes::class => fn (Container $container) => $container->get(SignUp::class),
];
