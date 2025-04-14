<?php

namespace App\Service;

use App\Entity\ConnectedObject;
use App\Entity\ConnectedObjectHistory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class HistoryLogger
{
    public function log(ConnectedObject $objet, UserInterface $user, EntityManagerInterface $em): void
    {
        $oldData = [
            'name' => $objet->getName(),
            'type' => $objet->getType(),
            'status' => $objet->getStatus(),
            'location' => $objet->getLocation(),
            'room' => $objet->getRoom(),
            'brand' => $objet->getBrand(),
            'description' => $objet->getDescription(),
            'currentTemp' => $objet->getCurrentTemp(),
            'targetTemp' => $objet->getTargetTemp(),
            'mode' => $objet->getMode(),
            'viewAngle' => $objet->getViewAngle(),
            'resolution' => $objet->getResolution(),
            'connectivity' => $objet->getConnectivity(),
            'signal' => $objet->getSignal(),
            'batteryLevel' => $objet->getBatteryLevel(),
            'storageCapacity' => $objet->getStorageCapacity(),
            'ram' => $objet->getRam(),
            'screenSize' => $objet->getScreenSize(),
            'os' => $objet->getOs()
        ];

        $history = new ConnectedObjectHistory();
        $history->setObject($objet);
        $history->setModifiedAt(new \DateTimeImmutable());
        $history->setModifiedBy($user);
        $history->setPreviousData($oldData);

        $em->persist($history);
    }
}

