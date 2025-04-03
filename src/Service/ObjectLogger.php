<?php

namespace App\Service;

use App\Entity\ObjectLog;
use App\Entity\ConnectedObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ObjectLogger
{
    private EntityManagerInterface $em;
    private TokenStorageInterface $tokenStorage;
    private string $logFile = 'var/log/deleted_object_buffer.json';

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function log(string $action, ConnectedObject $objet): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;
        $username = method_exists($user, 'getEmail') ? $user->getEmail() : 'Système';

        $log = new ObjectLog();
        $log->setObjectName($objet->getName());
        $log->setAction($action);
        $log->setPerformedBy($username);
        $log->setCreatedAt(new \DateTime());

        $this->em->persist($log);
        $this->em->flush();
    }

    public function prepareLogToFile(ConnectedObject $objet): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;
        $username = method_exists($user, 'getEmail') ? $user->getEmail() : 'Système';

        $data = [
            'name' => $objet->getName(),
            'action' => 'Suppression',
            'performedBy' => $username,
            'timestamp' => (new \DateTime())->format('Y-m-d H:i:s')
        ];

        file_put_contents($this->logFile, json_encode($data), LOCK_EX);
    }

    public function finalizeLogFromFile(): void
    {
        if (!file_exists($this->logFile)) return;

        $content = json_decode(file_get_contents($this->logFile), true);
        if (!$content || !isset($content['name'])) return;

        $log = new ObjectLog();
        $log->setObjectName($content['name']);
        $log->setAction($content['action']);
        $log->setPerformedBy($content['performedBy']);
        $log->setCreatedAt(new \DateTime($content['timestamp']));

        $this->em->persist($log);
        $this->em->flush();

        unlink($this->logFile); // Nettoyer le fichier
    }
}
