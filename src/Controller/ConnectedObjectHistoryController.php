<?php

namespace App\Controller;

use App\Entity\ConnectedObjectHistory;
use App\Repository\ConnectedObjectHistoryRepository;
use App\Repository\ConnectedObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnectedObjectHistoryController extends AbstractController
{
    #[Route('/objets/{id}/historique-modifications', name: 'app_objet_historique_modif')]
    public function historiqueModif(
        int $id,
        ConnectedObjectRepository $objectRepo,
        ConnectedObjectHistoryRepository $historyRepo
    ): Response {
        $objet = $objectRepo->find($id);

        if (!$objet) {
            throw $this->createNotFoundException("Objet non trouvé.");
        }

        $historiques = $historyRepo->findBy(
            ['object' => $objet],
            ['modifiedAt' => 'DESC']
        );

        return $this->render('historiqueObjets.html.twig', [
            'objet' => $objet,
            'historiques' => $historiques
        ]);
    }
}

