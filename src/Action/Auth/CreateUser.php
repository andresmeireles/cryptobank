<?php

declare(strict_types=1);

namespace CryptoBank\Action\Auth;

use CryptoBank\Action\ActionErrors;
use CryptoBank\Action\Api\Auth\CreateAuthUserInterface;
use CryptoBank\Action\Api\CreateJwtInterface;
use CryptoBank\Action\Api\CreateUserInterface;
use CryptoBank\Errors\Error;
use CryptoBank\Model\Account;
use CryptoBank\Model\Jwt;
use CryptoBank\Model\User;
use CryptoBank\Repository\Api\AccountRepositoryInterface;
use CryptoBank\Repository\Api\JwtRepositoryInterface;
use CryptoBank\Repository\Api\UserRepositoryInterface;
use Respect\Validation\Validator as v;

class CreateUser implements CreateUserInterface
{
    /**
     * @param UserRepositoryInterface $userRepository 
     * @param AccountRepositoryInterface $accountRepository 
     * @param JwtRepositoryInterface $jwtRepository 
     * @param CreateAuthUserInterface $createAuthUser 
     * @param CreateJwtInterface $createJwt 
     * @return void 
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly JwtRepositoryInterface $jwtRepository,
        private readonly CreateAuthUserInterface $createAuthUser,
        private readonly CreateJwtInterface $createJwt,
    )
    {
    }

    public function create(
        string $name,
        string $cpf,
        string $rg,
        string $birthDate,
        string $phone,
        string $email,
        ?string $password = null
    ): string|Error {
        $this->userRepository->beginTransaction();
        try {
            $validate = $this->validate($email, $cpf, $rg, $birthDate, $phone, $email);
            if ($validate instanceof Error) {
                return $validate;
            }
            $user = User::create($name, $cpf, $rg, new \DateTime($birthDate), $phone, $email);
            $createdUser = $this->userRepository->create($user);
            $account = Account::create($createdUser);
            $createdAccount = $this->accountRepository->create($account);
            $this->createAuthUser->create($createdUser, $createdAccount, $password);
            $jwt = $this->createJwt->create($createdUser->name);
            $jwtToken = Jwt::create($createdUser, $jwt);
            $this->jwtRepository->create($jwtToken);
            $this->userRepository->commit();
            return $jwt;
        } catch (\Exception $e) {
            $this->userRepository->rollback();
            throw $e;
        }
    }

    /**
     * @param string $name 
     * @param string $cpf 
     * @param string $rg 
     * @param string $birthDate 
     * @param string $phone 
     * @param string $address 
     * @return bool|Error 
     */
    public function validate(string $name, string $cpf, string $rg, string $birthDate, string $phone, string $address): bool|Error
    {
        if (!(v::cpf()->validate($cpf) || v::cnpj()->validate($cpf))) {
            return ActionErrors::INVALID_CPF_CNPJ;
        }
        if (!v::notEmpty()->validate($rg)) {
            return ActionErrors::INVALID_RG;
        }
        if (!v::stringType()->notEmpty()->notBlank()->validate($name)) {
            return ActionErrors::INVALID_NAME;
        }
        if (!v::date()->validate($birthDate)) {
            return ActionErrors::INVALID_DATE;
        }
        if (!v::phone()->validate($phone)) {
            return ActionErrors::INVALID_PHONE;
        }
        if (!v::notEmpty()->validate($address)) {
            return ActionErrors::INVALID_ADDRESS;
        }
        return true;
    }
}
