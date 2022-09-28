<?php

declare(strict_types=1);

namespace Cryptocli\Model;

use Cryptocli\Repository\AccountHistoryRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: AccountHistoryRepository::class)]
#[Table(name: 'account_history')]
class AccountHistory
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id;

    #[ManyToOne(targetEntity: Account::class, inversedBy: 'history')]
    #[JoinColumn(name: 'account_id', referencedColumnName: 'id')]
    public Account $account;

    #[Column(name: 'operation', type: 'integer', nullable: false, enumType: AccountOperations::class)]
    public AccountOperations $operation;

    #[Column(name: 'value', type: 'float', nullable: 'false')]
    public float $value;

    #[Column(name: 'register_date', type: 'datetime', nullable: false)]
    public \DateTime $registerDate;

    public static function create(Account $account, AccountOperations $accountOperations, float $value): self
    {
        $ah = new self();
        $ah->account = $account;
        $ah->operation = $accountOperations;
        $ah->value = $value;
        $ah->registerDate = new \DateTime('now');

        return $ah;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}