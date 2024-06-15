<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SecretPayloadDTO
{
    public function __construct(
        #[Assert\Length(min: 1, max: 255)]
        public readonly string $secret,

        #[Assert\Positive]
        public readonly int $expireAfterViews,

        #[Assert\PositiveOrZero]
        public readonly int $expireAfter,
    ) {
    }
}
