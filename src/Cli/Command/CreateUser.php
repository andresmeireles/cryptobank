<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Command;

use Cryptocli\Services\Register\CreateAccount;
use Cryptocli\Services\Register\CreateNewUser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'client:create',
    description: 'create new user and account',
    hidden: false
)]
class CreateUser extends Command
{
    public function __construct(
        private readonly CreateAccount $createAccount,
        private readonly CreateNewUser $createNewUser
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('name', null, InputOption::VALUE_REQUIRED, 'name or company name');
        $this->addOption('security-code', null, InputOption::VALUE_REQUIRED, 'cpf or cnpj');
        $this->addOption('identification', null, InputOption::VALUE_REQUIRED, 'rg or ie');
        $this->addOption('date', null, InputOption::VALUE_REQUIRED, 'birthdate or foundation date, format Y-m-d');
        $this->addOption('phone', null, InputOption::VALUE_REQUIRED, 'phone number');
        $this->addOption('address', null, InputOption::VALUE_REQUIRED, 'address');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getOption('name');
        $securityCode = $input->getOption('security-code');
        $identification = $input->getOption('identification');
        $date = \DateTime::createFromFormat('Y-m-d', $input->getOption('date'));
        $phone = $input->getOption('phone');
        $address = $input->getOption('address');
        $userData = new \Cryptocli\DTO\CreateUser($name, $securityCode, $identification, $date, $phone, $address);
        $user = $this->createNewUser->create($userData);
        $this->createAccount->create($user->getId());
        $output->writeln('account was created!');

        return self::SUCCESS;
    }
}