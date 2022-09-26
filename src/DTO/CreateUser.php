<?php

declare(strict_types=1);

namespace Cryptocli\DTO;

use Cryptocli\Model\User;

class CreateUser
{
    public function __construct(
        public readonly string $nameCommercialName,
        public readonly string $cnpjCpf,
        public readonly string $rgIE,
        public readonly \DateTime $dataNascimentoDataFundacao,
        public readonly string $phone,
        public readonly string $address,
    )
    {
    }

    public function toUser(): User
    {
        return User::create($this->nameCommercialName, $this->cnpjCpf, $this->rgIE, $this->dataNascimentoDataFundacao, $this->phone, $this->address);
    }
}