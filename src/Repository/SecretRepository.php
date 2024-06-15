<?php

namespace App\Repository;

use App\Entity\Secret;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SecretRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Secret::class);
    }

    public function findOneAvailableByHash(string $hash): ?Secret
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->where(['e.hash = :hash'])
            ->setParameter(':hash', $hash)
            ->andWhere('e.expiresAt > :date OR e.expiresAt IS NULL')
            ->setParameter(':date', new \DateTimeImmutable('now'))
            ->andWhere('e.remainingViews > 0');

        $query = $queryBuilder->getQuery();

        return $query->getOneOrNullResult();
    }
}
