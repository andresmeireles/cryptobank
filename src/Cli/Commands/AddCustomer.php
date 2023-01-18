<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Commands;

use Cryptocli\Action\Api\CreateUserInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function DI\create;

#[AsCommand(
    name: 'add_user',
    description: 'a simple message command',
    aliases: ['au'],
    hidden: false
)]
class AddCustomer extends Command
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
        $this->addOption('cpf', null, InputOption::VALUE_REQUIRED, 'cpf or cnpj');
        $this->addOption('birth_date', null, InputOption::VALUE_REQUIRED, 'birthdate or foundation date in yyyy-mm-dd format');
        $this->addOption('phone', null, InputOption::VALUE_REQUIRED, 'phone number');
        $this->addOption('email', null, InputOption::VALUE_REQUIRED, 'email');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption('name');
        $cpf = $input->getOption('cpf');
        $birthDate = $input->getOption('birth_date');
        $phone = $input->getOption('phone');
        $email = $input->getOption('email');
        if ($name === null || $cpf === null || $birthDate === null || $phone === null || $email === null) {
            $output->writeln('all parameters must be given');

            return Command::FAILURE;
        }
        $jwt = $this->createUser->create($name, $cpf, $birthDate, $phone, $email);
        $output->writeln(sprintf('usuario criado com token: %s', $jwt));

        return Command::SUCCESS;
    }
}