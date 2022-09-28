<?php

namespace Cryptocli\Model;

use Cryptocli\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: AccountRepository::class)]
#[Table(name: 'account')]
class Account
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id;

    #[Column(name: 'number', type: 'string', unique: true, nullable: false)]
    public string $number;

    #[OneToOne(inversedBy: 'account', targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    public User $user;

    #[Column(name: 'balance', type: 'float', nullable: false)]
    public float $balance = 0.0;

    /**
     * @var Collection<AccountHistory>
     */
    #[OneToMany(mappedBy: 'account', targetEntity: AccountHistory::class)]
    private Collection $history;

    public function __construct()
    {
        $this->history = new ArrayCollection();
    }

    public static function create(User $user): self
    {
        $account = new Account();
        $account->number = random_int(111111, 999999);
        $account->user = $user;

        return $account;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<AccountHistory>
     */
    public function getHistory(): Collection
    {
        return $this->history;
    }
}