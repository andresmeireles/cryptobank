<?php

declare(strict_types=1);

namespace Cryptocli\Services\Account;

use Cryptocli\Repository\Interfaces\UserRepositoryInterface;

class AccountVerification implements CheckAccount
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    public function checkUserAccount(string $account, int $userId): bool
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) return false;

        return $user->account->number === $account;
    }
}
