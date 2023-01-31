<?php

declare(strict_types=1);

namespace CryptoBank\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table(name: 'jwts')]
class Jwt
{
    #[Id()]
    #[Column(type: 'integer')]
    #[GeneratedValue()]
    private ?int $id;

    #[Column(type: 'string')]
    public string $token;

    public function getId(): ?int
    {
        return $this->id;
    }
}
