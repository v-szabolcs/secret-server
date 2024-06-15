<?php

namespace App\Mapper;

use App\DTO\SecretPayloadDTO;

class SecretPayloadMapper
{
    public function map(array $payload): SecretPayloadDTO
    {
        return new SecretPayloadDTO(
            $payload['secret'],
            $payload['expireAfterViews'],
            $payload['expireAfter'],
        );
    }
}
