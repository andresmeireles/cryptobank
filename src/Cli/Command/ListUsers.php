<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Command;

use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'client:list',
    description: 'lista all users registered',
    hidden: false,
)]
class ListUsers extends Command implements Authable
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('id', 'i', InputOption::VALUE_OPTIONAL, 'user id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            $output->writeln(sprintf('id: %s. name: %s. account: %s', $user->getId(), $user->nameCommercialName, $user->account->number));
        }

        return self::SUCCESS;
    }
}