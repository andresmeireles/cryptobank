<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'create:client',
    description: 'create new user and account',
    hidden: false
)]
class CreateUser extends Command
{
    protected function configure()
    {
        $this->addOption('name', 'n', InputOption::VALUE_REQUIRED, 'name or company name');
        $this->addOption('security-code', 'sc', InputOption::VALUE_REQUIRED, 'cpf or cnpj');
        $this->addOption('identification', 'id', InputOption::VALUE_REQUIRED, 'rg or ie');
        $this->addOption('date', 'd', InputOption::VALUE_REQUIRED, 'birthdate or foundation date');
        $this->addOption('phone', 'p', InputOption::VALUE_REQUIRED, 'phone number');
        $this->addOption('address', 'a', InputOption::VALUE_REQUIRED, 'address');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption('name');
        $securityCode = $input->getOption('security-code');
        $identification = $input->getOption('identification');
        $date = $input->getOption('date');
        $phone = $input->getOption('phone');
        $address = $input->getOption('address');


    }
}