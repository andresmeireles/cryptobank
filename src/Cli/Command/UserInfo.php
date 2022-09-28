<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Command;

use Cryptocli\Services\Auth\ValidateToken;
use Cryptocli\Services\ServiceError;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'auth:user:info',
    description: 'user information by given token',
    aliases: ['auth:info'],
)]
class UserInfo extends Command
{
    public function __construct(
        private readonly ValidateToken $validateToken
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('auth', 'a', InputOption::VALUE_REQUIRED, 'token to return user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $authToken = $input->getOption('auth');
        if ($authToken === null) {
            $output->writeln('no auth token sended');

            return self::FAILURE;
        }
        $user = $this->validateToken->userToken($authToken);
        if ($user instanceof ServiceError) {
            $output->writeln($user->errorMessage());
            return self::FAILURE;
        }
        $output->writeln(sprintf('id: %s. name: %s', $user->getId(), $user->nameCommercialName));

        return self::SUCCESS;
    }
}