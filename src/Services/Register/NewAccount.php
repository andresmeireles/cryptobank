<?php

declare(strict_types=1);

namespace Cryptocli\Services\Register;

use Cryptocli\Model\Account;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\AccountRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\ServiceError;

class NewAccount implements CreateAccount
{
    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    public function create(int $userId): Account|ServiceError
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            return RegisterErrors::USER_NOT_FOUND;
        }
        $account = Account::create($user);

        return $this->accountRepository->create($account);
    }
}