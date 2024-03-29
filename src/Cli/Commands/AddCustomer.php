<?php

declare(strict_types=1);

namespace CryptoBank\Cli\Commands;

use CryptoBank\Action\Api\CreateUserInterface;
use CryptoBank\Cli\Api\Catchable;
use CryptoBank\Errors\Error;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'add_user',
    description: 'a simple message command',
    aliases: ['au'],
    hidden: false,
)]
class AddCustomer extends Command implements Catchable
{
    public function __construct(
        private readonly CreateUserInterface $createUser,
        string $name = 'add_user',
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addOption('name', mode: InputOption::VALUE_REQUIRED, description: 'name or trade name');
        $this->addOption('rg', mode: InputOption::VALUE_REQUIRED, description: 'rg or ie code');
        $this->addOption('cpf', null, InputOption::VALUE_REQUIRED, 'cpf or cnpj');
        $this->addOption('birth_date', null, InputOption::VALUE_REQUIRED, 'birth date or foundation date in yyyy-mm-dd format');
        $this->addOption('phone', null, InputOption::VALUE_REQUIRED, 'phone number');
        $this->addOption('email', null, InputOption::VALUE_REQUIRED, 'email');
        $this->addOption('password', null, InputOption::VALUE_OPTIONAL, '[optional] password to created user, if not passed cpf/cnpj will be used as password');
        $this->addUsage('add_user --name=NAME --rg=RG_NUMBER --cpf=CPF_NUMBER --birth_date=2020-10-12 --phone=PHONE_NUMBER --email=EMAIL');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getOption('name');
        $cpf = $input->getOption('cpf');
        $rg = $input->getOption('rg');
        $birthDate = $input->getOption('birth_date');
        $phone = $input->getOption('phone');
        $email = $input->getOption('email');
        $password = $input->getOption('password');
        if ($name === null || $cpf === null || $birthDate === null || $phone === null || $email === null) {
            $output->writeln('all parameters must be given');
            return Command::INVALID;
        }
        $jwt = $this->createUser->create($name, $cpf, $rg, $birthDate, $phone, $email, $password);
        if ($jwt instanceof Error) {
            $output->writeln($jwt->message());
            return Command::FAILURE;
        }
        $output->writeln(sprintf('usuario criado com token: %s', $jwt));
        if ($password === null) {
            $output->writeln("[senha] CPF/CNPJ do cliente");
        }
        return Command::SUCCESS;
    }
}
