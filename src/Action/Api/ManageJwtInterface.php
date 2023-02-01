<?php

declare(strict_types=1);

namespace CryptoBank\Action\Api;

use CryptoBank\Model\Jwt;
use CryptoBank\Model\User;

interface ManageJwtInterface
{
    public function checkJwt(User $user): Jwt;
}
