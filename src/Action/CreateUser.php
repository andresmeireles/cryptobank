<?php

declare(strict_types=1);

namespace Cryptocli\Action;

use Cryptocli\Action\Api\CreateJwtInterface;
use Cryptocli\Action\Api\CreateUserInterface;
use Cryptocli\Errors\Error;
use Cryptocli\Errors\SystemError;
use Cryptocli\Model\Account;
use Cryptocli\Model\User;
use Cryptocli\Repository\Api\AccountRepositoryInterface;
use Cryptocli\Repository\Api\UserRepositoryInterface;
use Respect\Validation\Validator as v;

class CreateUser implements CreateUserInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly CreateJwtInterface $createJwt,
    )
    {
    }

    public function create(string $name, string $cpf, string $rg, string $birthDate, string $phone, string $email): string|Error
    {
        $validate = $this->validate($email, $cpf, $rg, $birthDate, $phone, $email);
        if ($validate instanceof Error) {
            return $validate;
        }
        $user = User::create($name, $cpf, $rg, new \DateTime($birthDate), $phone, $email);
            $createdUser = $this->userRepository->create($user);
            $account = Account::create($createdUser);
            $createdAccount = $this->accountRepository->create($account);
            return $this->createJwt->create($createdUser->name);
    }

    public function validate(string $name, string $cpf, string $rg, string $birthDate, string $phone, string $address): bool|Error
    {
        if (!(v::cpf()->validate($cpf) || v::cnpj()->validate($cpf))) {
            return ActonErrors::INVALID_CPF_CNPJ;
        }
        if (!v::notEmpty()->validate($rg)) {
            return ActonErrors::INVALID_RG;
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
        if (!v::notEmpty()->validate($address)) {
            return ActonErrors::INVALID_ADDRESS;
        }
        return true;
    }
}
