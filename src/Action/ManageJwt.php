<?php

declare(strict_types=1);

namespace CryptoBank\Action;

use CryptoBank\Action\Api\ManageJwtInterface;
use CryptoBank\Action\Api\CreateJwtInterface;
use CryptoBank\Action\Api\ParseJwtInterface;
use CryptoBank\Model\User;
use CryptoBank\Model\Jwt;
use CryptoBank\Repository\Api\JwtRepositoryInterface;

class ManageJwt implements ManageJwtInterface
{
    public function __construct(
        private readonly CreateJwtInterface $createJwt,
        private readonly JwtRepositoryInterface $jwtRepository,
        private readonly ParseJwtInterface $parseJwt,
    ) {
    }

    public function checkJwt(User $user): Jwt
    {
        $jwt = $this->jwtRepository->getByUserId($user->getId());
        if ($jwt === null) {
            return $this->addJwt($user);
        }
        $parsedJwt = $this->parseJwt->parse($jwt->token);
        if ($parsedJwt->isValid()) {
            return $jwt;
        }
        return $this->addJwt($user);
    }

    private function addJwt(User $user): Jwt
    {
        $newToken = $this->createJwt->create($user->name);
        $newJwt = Jwt::create($user, $newToken);
        return $this->jwtRepository->create($newJwt);
    }
}
