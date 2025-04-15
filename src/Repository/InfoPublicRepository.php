<?php
// src/Repository/InfoPublicRepository.php

namespace App\Repository;

use App\Entity\InfoPublic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InfoPublicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoPublic::class);
    }

    public function findByFilters(?string $categorie, ?string $departement): array
    {
        $qb = $this->createQueryBuilder('i');

        if ($categorie) {
            $qb->andWhere('i.categorie = :categorie')->setParameter('categorie', $categorie);
        }

        if ($departement) {
            $qb->andWhere('i.departement = :departement')->setParameter('departement', $departement);
        }

        return $qb->orderBy('i.id', 'DESC')->getQuery()->getResult();
    }
}