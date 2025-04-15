<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class PointsService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ajouterPoints(User $user, int $points): void
    {
        $actuels = (int)($user->getPoints() ?? 0);
        $user->setPoints($actuels + $points);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
