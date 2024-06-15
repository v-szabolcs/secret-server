<?php

namespace App\DTO;

class SecretPayloadDTO
{
    public function __construct(
        public string $secret,
        public int $expireAfterViews,
        public int $expireAfter,
    ) {
    }
}
