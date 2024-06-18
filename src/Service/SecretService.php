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

    /**
     * Create secret
     */
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

        return $this->secretMapper->toDTO($secret);
    }

    /**
     * Get secret
     */
    public function get(string $hash): ?SecretDTO
    {
        $repository = $this->entityManager->getRepository(Secret::class);

        $secret = $repository->findOneAvailableByHash($hash);

        if (!$secret) {
            return null;
        }

        $secret = $this->decreaseRemainingViews($secret);

        return $this->secretMapper->toDTO($secret);
    }

    /**
     * Generate hash
     */
    private function generateHash(): string
    {
        do {
            $hash = bin2hex(random_bytes(20));
        } while (!$this->isHashUnique($hash));

        return $hash;
    }

    /**
     * Check hash is unique in database
     */
    private function isHashUnique(string $hash): bool
    {
        $repository = $this->entityManager->getRepository(Secret::class);

        if ($repository->count(['hash' => $hash]) > 0) {
            return false;
        }

        return true;
    }

    /**
     * Store secret
     */
    private function store(SecretDTO $secretDTO): Secret
    {
        $secret = $this->secretMapper->toSecret($secretDTO);

        $this->entityManager->persist($secret);

        $this->entityManager->flush();

        return $secret;
    }

    /**
     * Decrease remaining views by one
     */
    private function decreaseRemainingViews(Secret $secret): Secret
    {
        $remainingViews = $secret->getRemainingViews();

        $secret->setRemainingViews($remainingViews - 1);

        $this->entityManager->persist($secret);

        $this->entityManager->flush();

        return $secret;
    }
}
