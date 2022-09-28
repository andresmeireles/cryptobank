<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

use Cryptocli\Model\AuthToken;
use Cryptocli\Model\User;
use Cryptocli\Repository\Interfaces\AuthTokenRepository;
use Cryptocli\Repository\Interfaces\UserRepositoryInterface;
use Cryptocli\Services\CommomErrors;
use Cryptocli\Services\ServiceError;
use Psr\Log\LoggerInterface;

class Login implements LoginTypes
{
    public function __construct(
        private readonly Jwt $jwt,
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuthTokenRepository $authTokenRepository,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function withUserAndPassword(string $userName, string $password): AuthToken|ServiceError
    {
        $user = $this->userRepository->findOneBy(['nameCommercialName' => $userName]);
        if ($user === null) {
            return CommomErrors::USER_NOT_FOUND;
        }
        $auth = $user->auth;
        if (!password_verify($password, $auth->password)) {
            return AuthErrors::WRONG_CREDENTIALS;
        }

        return $this->generateToken($user);
    }

    public function withAccountAndPassword(string $accountNumber, string $password): string|ServiceError
    {
        // TODO: Implement withAccountAndPassword() method.
    }

    private function generateToken(User $user): AuthToken
    {
        $jwtPayload = new JwtPayload($user->getId());
        $jwtToken = $this->jwt->encode($jwtPayload);
        $authTokenData = AuthToken::create($user, $jwtToken);
        $this->revokeActiveTokens($user); // TODO separar essa ação para um serviço especifico
        $authToken = $this->authTokenRepository->create($authTokenData);
        $this->logger->info(sprintf('token was emited to user %s', $user->getId()));

        return $authToken;
    }

    private function revokeActiveTokens(User $user): void
    {
        $tokens = $user->getToken();
        foreach ($tokens as $token) {
            $token->active = false;
            $this->authTokenRepository->update($token);
        }
    }
}