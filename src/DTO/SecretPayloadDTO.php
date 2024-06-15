<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SecretPayloadDTO
{
    public function __construct(
        #[Assert\Length(min: 1, max: 255)]
        public string $secret,

        #[Assert\Positive]
        public int $expireAfterViews,

        #[Assert\PositiveOrZero]
        public int $expireAfter,
    ) {
    }
}
