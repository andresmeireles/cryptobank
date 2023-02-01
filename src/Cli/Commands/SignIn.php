<?php

namespace CryptoBank\Cli\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use CryptoBank\Action\Auth\SignIn as SignInUser;
use CryptoBank\Cli\Api\Catchable;
use CryptoBank\Errors\Error;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'sign_in_with_pass',
    description: 'sign in with user name or account number and password',
    aliases: ['siwp'],
    hidden: false
)]
class SignIn extends Command implements Catchable
{
    public function __construct(
        private readonly SignInUser $signIn
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('user', mode: InputOption::VALUE_REQUIRED, description: 'User name or account number');
        $this->addOption('pass', mode: InputOption::VALUE_REQUIRED, description: 'User password');
        $this->addUsage('sign_in_with_pass --user=[USER_NAME/ACCOUNT_NUMBER] --pass=[PASS]');
        $this->addUsage('swip --user=[USER_NAME/ACCOUNT_NUMBER] --pass=[PASS]');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $input->getOption('user');
        $pass = $input->getOption('pass');
        if ($user === null || $pass === null) {
            $output->writeln('usuario e/ou senha não pode ser vazio');
            return Command::INVALID;
        }
        $user = $this->signIn->withPassword($user, $pass);
        if ($user instanceof Error) {
            $output->writeln($user->message());
            return Command::FAILURE;
        }
        $output->writeln("usuario connectado:");
        $output->writeln(sprintf("User %s", $user->name));
        $output->writeln(sprintf("CPF/CNPJ %s", $user->cnpjCpf));
        $output->writeln(sprintf("RG/IE %s", $user->rgIE));
        $output->writeln(sprintf("Telefone %s", $user->phone));
        $output->writeln(sprintf("Endereço %s", $user->address));
        $output->writeln(sprintf("Data de nascimento/fundação %s", $user->birthDateFoundationDate->format('dd/mm/YYYY')));
        $output->writeln(sprintf("Id da conta %s", $user->account->getId()));
        $output->writeln(sprintf("JWT %s", 'não tem'));

        return Command::SUCCESS;
    }
}
