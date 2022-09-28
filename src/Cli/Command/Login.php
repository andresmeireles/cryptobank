<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Command;

use Cryptocli\Services\Auth\LoginTypes;
use Cryptocli\Services\ServiceError;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'auth:login:user',
    description: 'login with user and password',
    aliases: ['auth:user'],
)]
class Login extends Command
{
    public function __construct(
        private readonly LoginTypes $login
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('user', 'u', InputOption::VALUE_REQUIRED, 'user to login');
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'password to login');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $input->getOption('user');
        $password = $input->getOption('password');
        $login = $this->login->withUserAndPassword($user, $password);
        if ($login instanceof ServiceError) {
            $output->writeln($login->errorMessage());

            return self::FAILURE;
        }
        $output->writeln($login->token);

        return self::SUCCESS;
    }
}