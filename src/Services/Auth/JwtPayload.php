<?php

declare(strict_types=1);

namespace Cryptocli\Services\Auth;

class JwtPayload
{
    public readonly \DateTime $expiresAt;

    public function __construct(public readonly int $userId, ?\DateTime $expiresAt = null)
    {
        $this->expiresAt = $expiresAt ?? (new \DateTime())->modify('+3600 seconds');
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'user' => $this->userId,
            'expiresAt' => $this->expiresAt->getTimestamp()
        ];
    }

    public function isExpired(): bool
    {
        return new \DateTime() > $this->expiresAt;
    }
}