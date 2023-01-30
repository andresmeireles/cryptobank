<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Encompass;

use Cryptocli\Cli\Api\Catchable;
use Cryptocli\Exception\CliMessageException;
use Cryptocli\Utils\Api\CrytoLoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CatchCommand extends Command {
    private readonly Command $command;
    private readonly CrytoLoggerInterface $logger;

    public function __construct(Command $command, CrytoLoggerInterface $logger)
    {
        if (!$command instanceof Catchable) {
            throw new \Exception('this is not a catchable command');
        }
        $this->command = $command;
        $this->logger = $logger;
        parent::__construct($command->getName());
    }

    protected function configure(): void
    {
        $this->setAliases($this->command->getAliases());
        $this->setDefinition($this->command->getDefinition());
        $this->setDescription($this->command->getDescription());
        array_map(fn ($usage) => $this->addUsage($usage), $this->command->getUsages());
        $this->command->configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            return $this->command->execute($input, $output);
        } catch (CliMessageException $err) {
            $this->logger->{$err->cliExceptionWeight->toString()}($err->getMessage());
            $output->writeln($err->errorMessage);
            return Command::FAILURE;
        } catch (\Exception $err) {
            $this->logger->error($err->getMessage());
            $output->writeln('Error on command execution, check log for more information');
            return Command::FAILURE;
        }
    }
}

