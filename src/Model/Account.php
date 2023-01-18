<?php

declare(strict_types=1);

namespace Cryptocli\Model;

use Cryptocli\Repository\AccountRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}