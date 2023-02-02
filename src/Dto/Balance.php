<?php

declare(strict_types=1);

namespace CryptoBank\Dto;

use CryptoBank\Model\Account;
use CryptoBank\Model\Balance as ModelBalance;
use CryptoBank\Utils\Api\EncryptInterface;

class Balance
{
    public function __construct(
        public readonly Account $account,
        public readonly float $balance,
        public readonly \DateTime $updatedAt,
    ) {}

    public function toBalance(EncryptInterface $encrypt): ModelBalance
    {
        $balance = new ModelBalance();
        $balance->account = $encrypt->encrypt((string) $this->account->getId());
        $balance->balance = $encrypt->encrypt((string) $this->balance);
        $balance->updatedAt = $encrypt->encrypt((string) $this->updatedAt->getTimestamp());
        return $balance;
    }
}
