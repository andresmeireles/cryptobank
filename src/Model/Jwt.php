<?php

declare(strict_types=1);

namespace CryptoBank\Model;

use CryptoBank\Repository\JwtRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: JwtRepository::class)]
#[Table(name: 'jwts')]
class Jwt
{
    #[Id()]
    #[Column(type: 'integer')]
    #[GeneratedValue()]
    private ?int $id;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    public User $user;

    #[Column(type: 'string')]
    public string $token;

    public static function create(User $user, string $jwtToken): self
    {
        $token = new self();
        $token->token = $jwtToken;
        $token->user = $user;
        return $token;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
