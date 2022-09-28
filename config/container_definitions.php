<?php

declare(strict_types=1);

use Cryptocli\Cli\Cli;
use Cryptocli\Cli\Command\CreateUser;
use Cryptocli\Cli\Command\ListUsers;
use Cryptocli\Cli\Command\UserInfo;
use Cryptocli\Cli\Command\ValidateToken;
use Cryptocli\Cli\SymfonyCli;
use Cryptocli\Repository\Interfaces\AccountRepository;
use Cryptocli\Repository\Interfaces\AuthRepository;
use Cryptocli\Repository\Interfaces\AuthTokenRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Repository\UserRepository;
use Cryptocli\Services\Auth\FirebaseJwt;
use Cryptocli\Services\Auth\Jwt;
use Cryptocli\Services\Auth\Login;
use Cryptocli\Services\Auth\LoginTypes;
use Cryptocli\Services\Auth\SignUp;
use Cryptocli\Services\Auth\SignUpTypes;
use Cryptocli\Services\Auth\TokenValidation;
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
            ListUsers::class,
            \Cryptocli\Cli\Command\Login::class,
            UserInfo::class,
            ValidateToken::class,
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
    AuthTokenRepository::class => fn (Container $container) => new \Cryptocli\Repository\AuthTokenRepository($container->get(EntityManagerInterface::class)),
    CreateNewUser::class => fn (Container $container) => $container->get(NewUser::class),
    CreateAccount::class => fn (Container $container) => $container->get(NewAccount::class),
    SignUpTypes::class => fn (Container $container) => $container->get(SignUp::class),
    Jwt::class => fn () => new FirebaseJwt($_ENV['JWT_SECRET'], 'HS256'),
    LoginTypes::class => fn (Container $container) => $container->get(Login::class),
    TokenValidation::class => fn (Container $container) => $container->get(\Cryptocli\Services\Auth\ValidateToken::class),
];
