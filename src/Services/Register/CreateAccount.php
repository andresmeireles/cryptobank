<?php

namespace Cryptocli\Services\Register;

use Cryptocli\Model\Account;
use Cryptocli\Services\ServiceError;

interface CreateAccount
{
    public function create(int $userId): Account|ServiceError;
}