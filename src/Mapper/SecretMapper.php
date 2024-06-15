<?php

namespace App\Mapper;

use App\DTO\SecretDTO;
use App\Entity\Secret;

class SecretMapper
{
    public function map(Secret $secret): SecretDTO
    {
        return new SecretDTO(
            $secret->getHash(),
            $secret->getSecretText(),
            $secret->getCreatedAt(),
            $secret->getExpiresAt(),
            $secret->getRemainingViews(),
        );
    }
}
