<?php

namespace App\Mapper;

use App\DTO\SecretPayloadDTO;

class SecretPayloadMapper
{
    /**
     * Map payload to DTO
     */
    public function toDTO(string $secret, int $expireAfterViews, int $expireAfter): SecretPayloadDTO
    {
        return new SecretPayloadDTO($secret, $expireAfterViews, $expireAfter);
    }
}
