<?php

namespace App\DTO;

class SecretDTO
{
    public function __construct(
        public readonly string $hash,
        public readonly string $secretText,
        public readonly \DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $expiresAt,
        public readonly int $remainingViews,
    ) {
    }
}
