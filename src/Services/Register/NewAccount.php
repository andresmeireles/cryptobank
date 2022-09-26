<?php

declare(strict_types=1);

namespace Cryptocli\Services\Register;

use Cryptocli\Model\Account;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\AccountRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\ServiceError;
use Psr\Log\LoggerInterface;

class NewAccount implements CreateAccount
{
    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function create(int $userId): Account|ServiceError
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            return RegisterErrors::USER_NOT_FOUND;
        }
        $account = $this->createAccount($user);
        $newAccount = $this->accountRepository->create($account);
        $this->logger->info(sprintf('account %s successfuly created', $account->number));

        return $newAccount;
    }

    private function createAccount(User $user): Account
    {
        $newAccount = Account::create($user);
        $accountExists = $this->accountRepository->findBy(['number' => $newAccount->number]);
        if ($accountExists !== []) {
            return $this->createAccount($user);
        }

        return $newAccount;
    }
}