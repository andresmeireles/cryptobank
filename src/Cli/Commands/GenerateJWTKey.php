<?php

declare(strict_types=1);

namespace CryptoBank\Cli\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'generate_jwt_keys', description: 'Generate Jwt key', aliases: ['gjk'], hidden: false)]
class GenerateJWTKey extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $envPath = $this->getEnvFile();
            $content = file_get_contents($envPath);
            $jwt = bin2hex(random_bytes(12));
            file_put_contents($envPath, str_replace('JWT_KEY=' . $_ENV['JWT_KEY'], 'JWT_KEY='. $jwt, $content));
            $output->writeln('generated jwt key');
            return Command::SUCCESS;
        } catch (\Exception $err) {
            $output->writeln($err->getMessage());
            return Command::FAILURE;
        }    
    }

    private function getEnvFile(?string $dir = null): string
    {
        $file = __DIR__ . $dir . '/.env';
        $length = explode('/', $file);
        if (count($length) > 35) {
            throw new \Exception('env file not exists');
        }
        if (file_exists($file)) {
            return $file;
        }
        return $this->getEnvFile($dir . '/..');
    }

}
