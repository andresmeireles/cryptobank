<?php

declare(strict_types=1);

namespace CryptoBank\Dto;

use CryptoBank\Model\Account;
use CryptoBank\Model\Balance;
use CryptoBank\Model\BalanceHistory as ModelBalanceHistory;
use CryptoBank\Utils\Api\EncryptInterface;

class BalanceHistory
{
    public function __construct(
        public readonly Balance $balance,
        public readonly Account $account,
        public readonly BalanceOperation $operation,
        public readonly float $value,
        public readonly \DateTime $createdAt,
    ) {}

    public function toBalanceHistory(EncryptInterface $encrypt): ModelBalanceHistory
    {
        $bh = new ModelBalanceHistory();
        $bh->balance = $encrypt->encrypt((string) $this->balance->getId());
        $bh->account = $encrypt->encrypt((string) $this->account->getId());
        $bh->createdAt = $encrypt->encrypt((string) $this->createdAt->getTimestamp());
        $bh->value = $encrypt->encrypt((string) $this->value);
        $bh->operation = $encrypt->encrypt($this->operation->name);
        return $bh;
    }
}
