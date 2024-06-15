<?php

namespace App\DTO;

class SecretDTO
{
    public function __construct(
        private string $hash,
        private string $secretText,
        private \DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $expiresAt,
        private int $remainingViews,
    ) {
    }
}
