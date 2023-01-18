<?php

declare(strict_types=1);

namespace Cryptocli\Model;

use Cryptocli\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'user')]
class User
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id;

    #[Column(name: 'name', type: 'string', nullable: false)]
    public string $name;

    #[Column(name: 'commercial_name', type: 'string', nullable: false)]
    public string $commercialName;

    #[Column(name: 'cnpj_cpf', type: 'string', nullable: false)]
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
}