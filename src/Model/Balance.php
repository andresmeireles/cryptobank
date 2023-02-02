<?php

declare(strict_types=1);

namespace CryptoBank\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

class Balance
{
    #[Id]
    #[GeneratedValue()]
    #[Column(type: 'integer')]
    private ?int $id;

    #[Column(type: 'string', unique: true)]
    public string $account;

    #[Column(type: 'string')]
    public string $balance;

    #[Column(type: 'string', name: 'updated_at')]
    public string $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }
}
