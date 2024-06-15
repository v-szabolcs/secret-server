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

    public function get(string $hash): ?SecretDTO
    {
        $repository = $this->entityManager->getRepository(Secret::class);

        $secret = $repository->findOneAvailableByHash($hash);

        if (!$secret) {
            return null;
        }

        $secret = $this->decreaseRemainingViews($secret);

        return $this->secretMapper->map($secret);
    }

    private function generateHash(): string
    {
        do {
            $hash = bin2hex(random_bytes(20));
        } while (!$this->isHashUnique($hash));

        return $hash;
    }

    private function isHashUnique(string $hash): bool
    {
        $repository = $this->entityManager->getRepository(Secret::class);

        if ($repository->count(['hash' => $hash]) > 0) {
            return false;
        }

        return true;
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

    private function decreaseRemainingViews(Secret $secret): Secret
    {
        $remainingViews = $secret->getRemainingViews();

        $secret->setRemainingViews($remainingViews - 1);

        $this->entityManager->persist($secret);

        $this->entityManager->flush();

        return $secret;
    }
}
