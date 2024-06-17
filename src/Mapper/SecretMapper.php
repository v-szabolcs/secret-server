<?php

namespace App\Mapper;

use App\DTO\SecretDTO;
use App\Entity\Secret;

class SecretMapper
{
    public function toDTO(Secret $secret): SecretDTO
    {
        return new SecretDTO(
            $secret->getHash(),
            $secret->getSecretText(),
            $secret->getCreatedAt(),
            $secret->getExpiresAt(),
            $secret->getRemainingViews(),
        );
    }

    public function toSecret(SecretDTO $secretDTO): Secret
    {
        $secret = new Secret();

        $secret->setHash($secretDTO->hash);
        $secret->setSecretText($secretDTO->secretText);
        $secret->setCreatedAt($secretDTO->createdAt);
        $secret->setExpiresAt($secretDTO->expiresAt);
        $secret->setRemainingViews($secretDTO->remainingViews);

        return $secret;
    }
}
