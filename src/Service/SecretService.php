<?php

namespace App\Service;

use App\DTO\SecretDTO;
use App\Entity\Secret;
use App\Mapper\SecretMapper;
use App\DTO\SecretPayloadDTO;
use Doctrine\ORM\EntityManagerInterface;

class SecretService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SecretMapper $secretMapper,
    ) {
    }

    public function create(SecretPayloadDTO $secretPayloadDTO): SecretDTO
    {
        $createdAt = new \DateTimeImmutable('now');
        $expiresAt = $secretPayloadDTO->expireAfter > 0 ? $createdAt->modify('+' . $secretPayloadDTO->expireAfter . ' minutes') : null;

        $secretDTO = new SecretDTO(
            $this->generateHash(),
            $secretPayloadDTO->secret,
            $createdAt,
            $expiresAt,
            $secretPayloadDTO->expireAfterViews,
        );

        $secret = $this->store($secretDTO);

        return $this->secretMapper->map($secret);
    }

    private function generateHash(): string
    {
        $repository = $this->entityManager->getRepository(Secret::class);

        do {
            $hash = bin2hex(random_bytes(20));
        } while ($repository->count(['hash' => $hash]) > 0);

        return $hash;
    }

    private function store(SecretDTO $secretDTO): Secret
    {
        $secret = new Secret();

        $secret->setHash($secretDTO->hash);
        $secret->setSecretText($secretDTO->secretText);
        $secret->setCreatedAt($secretDTO->createdAt);
        $secret->setExpiresAt($secretDTO->expiresAt);
        $secret->setRemainingViews($secretDTO->remainingViews);

        $this->entityManager->persist($secret);

        $this->entityManager->flush();

        return $secret;
    }
}
