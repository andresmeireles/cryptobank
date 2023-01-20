<?php

declare(strict_types=1);

namespace Cryptocli\Cli;

use Cryptocli\Cli\Api\Catchable;
use Cryptocli\Cli\Encompass\CatchCommand;
use Cryptocli\Utils\Api\CrytoLoggerInterface;
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
            $class = $this->container->get($command);
            if ($class instanceof Catchable) {
                $app->add(new CatchCommand($class, $this->container->get(CrytoLoggerInterface::class)));
                continue;
            }
            $app->add($class);
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
        $app = $this->bootstrap(); // get application object
        $app->setAutoExit(false);
        // get command and parameters
        $input = [
            $command->commandName,
            ...$command->arguments
        ];
        // send to input
        $arrayInput = new ArrayInput($input);
        // create return mode
        $output = new BufferedOutput();
        // execute command sended in arrayInput and put response on output
        $app->run($arrayInput, $output);
        // show response
        return $output->fetch();
    }
}
