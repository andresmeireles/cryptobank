<?php

namespace Cryptocli\Services\Auth;

use Cryptocli\Model\Auth;
use Cryptocli\Services\ServiceError;

interface SignUpTypes
{
    public function createSignUp(int $userId, string $nonHashedPassword): Auth|ServiceError;
}