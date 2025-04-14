<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByFilters(?string $query, ?string $role): array
    {
        $qb = $this->createQueryBuilder('u');

        if ($query) {
            $qb->andWhere('LOWER(u.firstname) LIKE :q OR LOWER(u.lastname) LIKE :q OR LOWER(u.pseudo) LIKE :q OR LOWER(u.email) LIKE :q')
               ->setParameter('q', '%' . strtolower($query) . '%');
        }

        if ($role) {
            $qb->andWhere('u.roles LIKE :role')
               ->setParameter('role', '%\"' . $role . '\"%');
        }

        return $qb->orderBy('u.lastname', 'ASC')->getQuery()->getResult();
    }
}