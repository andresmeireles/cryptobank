<?php

namespace Cryptocli\Cli;

use DI\Container;
use Symfony\Component\Console\Application;
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
            $app->add($this->container->get($command));
        }

        return $app;
    }

    public function allCommands(): void
    {
        $app = $this->bootstrap();
        $app->run();
    }

    public function executeCommand(CommandInput $command): string
    {
        $app = $this->bootstrap();
        $app->setAutoExit(false);
        $input = [
            $command->commandName,
            ...$command->arguments
        ];
        $arrayInput = new ArrayInput($input);
        $output = new BufferedOutput();
        $app->run($arrayInput, $output);

        return $output->fetch();
    }
}