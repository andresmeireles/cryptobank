<?php

declare(strict_types=1);

namespace CryptoBank\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table(name: 'auths')]
class Auth
{
    #[Id]
    #[GeneratedValue()]
    #[Column(type: 'integer')]
    private ?int $id;

    #[OneToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    public User $user;
    
    #[OneToOne(targetEntity: Account::class)]
    #[JoinColumn(name: 'account_id', referencedColumnName: 'id')]
    public Account $account;

    #[Column(type: 'string')]
    public string $password;

    public static function create(User $user, Account $account, string $password): self
    {
        $auth = new self;
        $auth->password = $password;
        $auth->user = $user;
        $auth->account = $account;
        return $auth;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
