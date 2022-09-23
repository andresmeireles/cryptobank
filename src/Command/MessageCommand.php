<?php

declare(strict_types=1);

namespace Cryptocli\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'message',
    description: 'a simple message command',
    hidden: false
)]
class MessageCommand extends Command
{
    protected const NAME = 'message';

    protected function configure()
    {
        $this->addOption('message', 'm',  InputOption::VALUE_REQUIRED, 'message');
        $this->addUsage('-m kek');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = $input->getOption('message');
        if ($message === null) {
            $output->writeln('no message send');

            return Command::FAILURE;
        }

        $output->writeln('uma mensagem foi escrita aqui: '. $message);

        return Command::SUCCESS;
    }
}