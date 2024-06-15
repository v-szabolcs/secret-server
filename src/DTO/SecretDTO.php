<?php

namespace App\DTO;

class SecretDTO
{
    public function __construct(
        public string $hash,
        public string $secretText,
        public \DateTimeImmutable $createdAt,
        public ?\DateTimeImmutable $expiresAt,
        public int $remainingViews,
    ) {
    }
}
