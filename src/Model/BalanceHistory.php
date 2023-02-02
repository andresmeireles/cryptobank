<?php

declare(strict_types=1);

namespace CryptoBank\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

class BalanceHistory
{
    #[Id]
    #[GeneratedValue()]
    #[Column(type: 'integer')]
    private ?int $id;

    #[Column(type: 'string')]
    public string $account;

    #[Column(type: 'string')]
    public string $balance;

    #[Column(type: 'string')]
    public string $operation;

    #[Column(type: 'string')]
    public string $value;

    #[Column(type: 'string', name: 'created_at')]
    public string $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }
}
