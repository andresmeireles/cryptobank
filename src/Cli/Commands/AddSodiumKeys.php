<?php

declare(strict_types=1);

namespace CryptoBank\Cli\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'gen_sodium_keys',
    description: 'generate new sodium key and nonce',
    aliases: ['gsk'],
    hidden: false 
)]
class AddSodiumKeys extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $file = $this->getEnvFile();
            $content = file_get_contents($file);
            file_put_contents(
                $file,
                str_replace('SECRET_KEY='.$_ENV['SECRET_KEY'], 'SECRET_KEY='.$this->generateKey(),$content)
            );
            $content = file_get_contents($file);
            file_put_contents(
                $file,
                str_replace('SECRET_NONCE='.$_ENV['SECRET_NONCE'], 'SECRET_NONCE='.$this->generateNonce(),$content)
            );
            $output->writeln('successfully generated keys');
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

    private function generateKey(): string
    {
        $key = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
        return bin2hex($key);
    }

    private function generateNonce(): string
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        return bin2hex($nonce);
    }
}
