<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Command;

use Cryptocli\Services\Auth\TokenValidation;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'auth:token:validate',
    description: 'validate user token',
    aliases: ['auth:validate']
)]
class ValidateToken extends Command
{
    public function __construct(
        private readonly TokenValidation $tokenValidation
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('token', InputArgument::REQUIRED, 'token to verify');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $token = $input->getArgument('token');
        if (strlen(trim($token)) === 0) {
            return self::INVALID;
        }
        $valid = $this->tokenValidation->validate($token);

        return $valid ? self::SUCCESS : self::FAILURE;
    }
}