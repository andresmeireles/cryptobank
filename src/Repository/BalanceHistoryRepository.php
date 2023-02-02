<?php

declare(strict_types=1);

namespace CryptoBank\Repository;

use CryptoBank\Dto\BalanceHistory as DtoBalanceHistory;
use CryptoBank\Model\Account;
use CryptoBank\Model\BalanceHistory;
use CryptoBank\Repository\Api\BalanceHistoryRepositoryInterface;
use CryptoBank\Utils\Api\EncryptInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<BalanceHistory>
 */
class BalanceHistoryRepository extends Repository implements BalanceHistoryRepositoryInterface
{
    public function __construct(
        private readonly EncryptInterface $encrypt,
        EntityManagerInterface $em
    ) {
        parent::__construct($em, BalanceHistory::class);
    }

    public function createFromDto(DtoBalanceHistory $balanceHistory): BalanceHistory
    {
        return $this->create($balanceHistory->toBalanceHistory($this->encrypt));
    }

    /** @inheritdoc */
    public function findByAccount(Account $account): array
    {
        $accountId = $this->encrypt->encrypt((string) $account->getId());
        return $this->findBy(['account' => $accountId]);
    }
}
