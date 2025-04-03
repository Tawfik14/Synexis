<?php

namespace App\Repository;

use App\Entity\ObjectLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ObjectLog>
 */
class ObjectLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectLog::class);
    }

    /**
     * @return ObjectLog[] Returns logs for a specific object ID, sorted by date DESC
     */
    public function findByObjetId(int $objetId): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.objet = :id')
            ->setParameter('id', $objetId)
            ->orderBy('l.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
