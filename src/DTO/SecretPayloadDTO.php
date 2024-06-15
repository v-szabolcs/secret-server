<?php

namespace App\DTO;

class SecretPayloadDTO
{
    public function __construct(
        private string $secret,
        private int $expireAfterViews,
        private int $expireAfter,
    ) {
    }
}
