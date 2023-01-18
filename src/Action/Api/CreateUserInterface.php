<?php

declare(strict_types=1);

namespace Cryptocli\Action\Api;

use Cryptocli\Errors\Error;

interface CreateUserInterface
{
    public function create(string $name, string $cpf, string $birthDate, string $phone, string $email): string|Error;
}