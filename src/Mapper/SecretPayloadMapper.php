<?php

namespace App\Mapper;

use App\DTO\SecretPayloadDTO;

class SecretPayloadMapper
{
    public function map(string $secret, int $expireAfterViews, int $expireAfter): SecretPayloadDTO
    {
        return new SecretPayloadDTO(
            $secret,
            $expireAfterViews,
            $expireAfter,
        );
    }
}
