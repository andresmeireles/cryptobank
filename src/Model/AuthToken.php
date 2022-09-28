<?php

declare(strict_types=1);

namespace Cryptocli\Model;

use Cryptocli\Repository\AuthTokenRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: AuthTokenRepository::class)]
#[Table(name: 'auth_token')]
class AuthToken
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'authToken')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    public User $user;

    #[Column(name: 'token', type: 'string', nullable: false)]
    public string $token;

    #[Column(name: 'active', type: 'boolean', nullable: false)]
    public bool $active = true;

    public static function create(User $user, string $token): self
    {
        $at = new self();
        $at->user = $user;
        $at->token = $token;

        return $at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}