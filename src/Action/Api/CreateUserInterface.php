<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api;

use CryptoBank\Errors\Error;

interface CreateUserInterface
{
    public function create(string $name, string $cpf, string $rg, string $birthDate, string $phone, string $email, string $password): string|Error;
}
