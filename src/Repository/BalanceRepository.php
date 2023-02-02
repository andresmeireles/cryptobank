<?php

declare(strict_types=1);

namespace CryptoBank\Repository;

use CryptoBank\Dto\Balance as DtoBalance;
use CryptoBank\Model\Account;
use CryptoBank\Model\Balance;
use CryptoBank\Repository\Api\BalanceRepositoryInterface;
use CryptoBank\Utils\Api\EncryptInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends Repository<Balance>
 */
class BalanceRepository extends Repository implements BalanceRepositoryInterface
{
    public function __construct(
        private readonly EncryptInterface $encrypt,
        EntityManagerInterface $em,
    ) {
        parent::__construct($em, Balance::class);
    }

    public function createFromDto(DtoBalance $balance): Balance
    {
        return $this->create($balance->toBalance($this->encrypt));
    }

    public function findOneByAccount(Account $account): ?Balance
    {
        $accountId = $this->encrypt->encrypt((string) $account->getId());
        return $this->findOneBy(['account' => $accountId]);
    }
}
