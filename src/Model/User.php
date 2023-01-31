<?php

declare(strict_types=1);

namespace CryptoBank\Model;

use CryptoBank\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'users')]
class User
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id;

    #[Column(name: 'name', type: 'string', nullable: false)]
    public string $name;

    #[Column(name: 'cnpj_cpf', type: 'string', unique: true, nullable: false)]
    public string $cnpjCpf;

    #[Column(name: 'rg_ie', type: 'string', nullable: false)]
    public string $rgIE;

    #[Column(name: 'birth_date_foundation_date', type: 'date', nullable: false)]
    public \DateTime $birthDateFoundationDate;

    #[Column(name: 'phone', type: 'string', nullable: false)]
    public string $phone;

    #[Column(name: 'address', type: 'string', nullable: false)]
    public string $address;

    #[OneToOne(mappedBy: 'user', targetEntity: Account::class)]
    public Account $account;

    public function getId(): ?int
    {
        return $this->id;
    }

    public static function create(string $name, string $cpf, string $rg, \DateTime $birthDate, string $phone, string $address): self
    {
        $user = new self();
        $user->name = $name;
        $user->cnpjCpf = $cpf;
        $user->rgIE = $rg;
        $user->birthDateFoundationDate = $birthDate;
        $user->phone = $phone;
        $user->address = $address;
        return $user;
    }
}
