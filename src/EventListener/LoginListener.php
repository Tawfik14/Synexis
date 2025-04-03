<?php

namespace App\EventListener;

use App\Entity\UserLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginListener
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (method_exists($user, 'getEmail')) {
            $log = new UserLog();
            $log->setUserEmail($user->getEmail());
            $log->setAction('Connexion');
            $log->setCreatedAt(new \DateTime());

            $this->em->persist($log);
            $this->em->flush();
        }
    }
}
