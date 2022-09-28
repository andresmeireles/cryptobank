<?php

namespace Cryptocli\Services\Account;

interface Add
{
    public function deposit(string $accountCode, float $value): void;
}