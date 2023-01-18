<?php

namespace Cryptocli\Action;

use Cryptocli\Action\Api\CreateUserInterface;
use Cryptocli\Errors\Error;
use Respect\Validation\Validator as v;

class CreateUser implements CreateUserInterface
{
    public function create(string $name, string $cpf, string $birthDate, string $phone, string $email): string|Error
    {
        $validate = $this->validate($email, $cpf, $birthDate, $phone, $email);
        if ($validate instanceof Error) {
            return $validate;
        }
        return 'jwt';
    }

    public function validate(string $name, string $cpf, string $birthDate, string $phone, string $email): bool|Error
    {
        if (!(v::cpf()->validate($cpf) || v::cnpj()->validate($cpf))) {
            return ActonErrors::INVALID_CPF_CNPJ;
        }
        if (!v::stringType()->notEmpty()->notBlank()->validate($name)) {
            return ActonErrors::INVALID_NAME;
        }
        if (!v::date()->validate($birthDate)) {
            return ActonErrors::INVALID_DATE;
        }
        if (!v::phone()->validate($phone)) {
            return ActonErrors::INVALID_PHONE;
        }
        if (!v::email()->validate($email)) {
            return ActonErrors::INVALID_EMAIL;
        }
        return true;
    }
}