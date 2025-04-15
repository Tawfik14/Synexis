<?php

namespace App\EventListener;

use App\Entity\UserLog;
use App\Service\PointsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginListener
{
    private EntityManagerInterface $em;
    private PointsService $pointsService;

    public function __construct(EntityManagerInterface $em, PointsService $pointsService)
    {
        $this->em = $em;
        $this->pointsService = $pointsService;
    }

    public function __invoke(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (method_exists($user, 'getEmail')) {
            $log = new UserLog();
            $log->setUserEmail($user->getEmail());
            $log->setAction('Connexion');
            $log->setCreatedAt(new \DateTime());

            // Ajout des points avec le service validé
            $this->pointsService->ajouterPoints($user, 0.25);

            $this->em->persist($log);
            $this->em->flush();
        }
    }
}
