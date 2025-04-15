<?php

namespace App\Repository;

use App\Entity\ConnectedObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ConnectedObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnectedObject::class);
    }

    public function countByType(): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.type, COUNT(o.id) as count')
            ->groupBy('o.type')
            ->getQuery()
            ->getResult();
    }

    public function countByStatus(): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.status, COUNT(o.id) as count')
            ->groupBy('o.status')
            ->getQuery()
            ->getResult();
    }

    public function countByLocation(): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.location as location, COUNT(o.id) as count')
            ->groupBy('o.location')
            ->getQuery()
            ->getResult();
    }

    public function countByBrand(): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.brand as brand, COUNT(o.id) as count')
            ->groupBy('o.brand')
            ->getQuery()
            ->getResult();
    }

}
