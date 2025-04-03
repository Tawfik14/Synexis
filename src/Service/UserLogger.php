<?php

namespace App\Service;

use App\Entity\UserLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserLogger
{
    private EntityManagerInterface $em;
    private TokenStorageInterface $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function log(string $action): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        if ($user && method_exists($user, 'getEmail')) {
            $log = new UserLog();
            $log->setUserEmail($user->getEmail());
            $log->setAction($action);
            $log->setCreatedAt(new \DateTime());

        $points = strtolower($action) === 'connexion' ? 0.25 : 0.0;
        $user->setPoints($user->getPoints() + $points);


            $this->em->persist($log);
            $this->em->flush();
        }
    }
}
