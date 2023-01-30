<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Encompass;

use Cryptocli\Cli\Api\Catchable;
use Cryptocli\Exception\CliExceptionWeight;
use Cryptocli\Exception\CliMessageException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AuthenticatedCommand extends Command implements Catchable
{
    public function __construct(private readonly Command $command) {
        parent::__construct($command->getName());
    }

    protected function configure(): void
    {
        $this->setAliases($this->command->getAliases());
        $this->setDefinition($this->command->getDefinition());
        $this->setDescription($this->command->getDescription());
        array_map(fn ($usage) => $this->addUsage(sprintf("%s %s", $usage, '--auth=auth_key')), $this->command->getUsages());
        $this->addOption('auth', null, InputOption::VALUE_REQUIRED, 'auth key (normally jwt)');
        parent::configure(); 
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
{
        $auth = $input->getOption('auth');
        if ($auth === null || trim($auth) === '') {
            throw new CliMessageException('no auth code sended', CliExceptionWeight::ERROR, 'no auth coded sendo on class that uses auth command.');
        }
        return $this->command->execute($input, $output);
    } 
}
