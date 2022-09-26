<?php

declare(strict_types=1);

namespace Cryptocli\Model;

use Cryptocli\Repository\AuthRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: AuthRepository::class)]
#[Table(name: 'auth')]
class Auth
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id;

    #[OneToOne(inversedBy: 'auth', targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id', unique: true, nullable: false)]
    public User $user;

    #[Column(name: 'password', type: 'string', nullable: false)]
    public string $password;

    public static function create(User $user, string $password): self
    {
        $auth = new self();
        $auth->user = $user;
        $auth->password = $password;

        return $auth;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}