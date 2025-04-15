<?php

namespace App\Controller;

use App\Entity\ObjectLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ObjectLogController extends AbstractController
{
    #[Route('/admin/object-logs', name: 'admin_object_logs')]
    public function showLogs(EntityManagerInterface $em): Response
    {
        $logs = $em->getRepository(ObjectLog::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('object_logs.html.twig', [
            'logs' => $logs,
        ]);
    }
}
