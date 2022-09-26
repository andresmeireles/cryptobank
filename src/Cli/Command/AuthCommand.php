<?php

declare(strict_types=1);

namespace Cryptocli\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class AuthCommand extends Command
{
    public function __construct(
        private readonly Command $command
    )
    {
        $this->setDescription($this->command->getDescription());
        parent::__construct($this->command->getName());
    }

    public function configure(): void
    {
        $previousOptions = $this->command->getDefinition()->getOptions();
        $this->getParenteCommandOptions($previousOptions);

        $this->addOption('auth', 'a', InputOption::VALUE_REQUIRED, 'auth token');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $auth = $input->getOption('auth');
        if ($auth === null) {
            $output->writeln('auth fail');

            return Command::INVALID;
        }

        return $this->command->execute($input, $output);
    }

    /**
     * @param InputOption[] $options
     * @return void
     */
    private function getParenteCommandOptions(array $options): void
    {
        foreach ($options as $option) {
            $this->addOption($option->getName(), $option->getShortcut(), $this->getOptionType($option), $option->getDescription());
        }
    }

    private function getOptionType(InputOption $option): int
    {
        if ($option->isValueRequired()) {
            return InputOption::VALUE_REQUIRED;
        }
        if ($option->isValueOptional()) {
            return InputOption::VALUE_OPTIONAL;
        }
        if ($option->isNegatable()) {
            return InputOption::VALUE_NEGATABLE;
        }
        if ($option->isArray()) {
            return InputOption::VALUE_IS_ARRAY;
        }

        return InputOption::VALUE_NONE;
    }
}