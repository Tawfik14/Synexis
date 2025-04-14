<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LevelController extends AbstractController
{
    #[Route('/mon-niveau', name: 'app_user_level')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function showLevel(): Response
    {
        return $this->render('user_level.html.twig');
    }

    #[Route('/changer-niveau', name: 'app_change_level', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function changeLevel(Request $request, EntityManagerInterface $em, \App\Service\UserLogger $logger): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $level = $request->request->get('level');
        $levelPoints = [
            'debutant' => 0,
            'intermediaire' => 5,
            'avance' => 10,
            'expert' => 15,
        ];

        if (!array_key_exists($level, $levelPoints)) {
            $this->addFlash('error', 'Niveau non valide.');
            return $this->redirectToRoute('app_user_level');
        }

        if ($user->getPoints() < $levelPoints[$level]) {
            $this->addFlash('error', 'Vous n\'avez pas assez de points.');
            return $this->redirectToRoute('app_user_level');
        }

        $user->setLevel($level);
        $logger->log('Changement de niveau');
        $em->flush();

        $this->addFlash('success', 'Niveau mis à jour avec succès !');
        return $this->redirectToRoute('app_user_level');
    }
}