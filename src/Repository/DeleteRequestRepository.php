<?php

namespace App\Repository;

use App\Entity\DeleteRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeleteRequest>
 */
class DeleteRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeleteRequest::class);
    }

    // Tu peux ajouter ici des méthodes personnalisées si besoin
}