<?php

namespace Cryptocli\Cli;

use Cryptocli\Cli\Command\Authable;
use Cryptocli\Cli\Command\AuthCommand;
use DI\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class SymfonyCli implements Cli
{
    public function __construct(
        public readonly Container $container,
        /**
         * @var class-string[]
         */
        public readonly array $commands
    )
    {
    }

    private function bootstrap(): Application
    {
        $app = new Application();
        foreach ($this->commands as $command) {
            $commandInstance = $this->container->get($command);
            if (!($commandInstance instanceof Command)) {
                throw new \LogicException('some commands are invalid');
            }
            if ($commandInstance instanceof Authable) {
                $commandInstance = new AuthCommand($commandInstance, $this);
            }
            $app->add($commandInstance);
        }

        return $app;
    }

    public function allCommands(): void
    {
        $app = $this->bootstrap();
        $app->run();
    }

    public function executeCommand(CommandInput $command): CommandResult
    {
        $app = $this->bootstrap();
        $app->setAutoExit(false);
        $input = [
            $command->commandName,
            ...$command->arguments
        ];
        $arrayInput = new ArrayInput($input);
        $output = new BufferedOutput();
        $code = $app->run($arrayInput, $output);

        return new CommandResult($code, $output->fetch());
    }
}