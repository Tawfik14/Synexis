<?php

namespace App\Controller;

use App\Entity\ConnectedObject;
use App\Repository\ConnectedObjectRepository;
use App\Service\ObjectLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ConnectedObjectController extends AbstractController
{
    #[Route('/objets/{id}/delete', name: 'app_objets_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        ConnectedObject $objet,
        EntityManagerInterface $em,
        ObjectLogger $logger
    ): Response {
        file_put_contents('var/log/controller_test.txt', "DELETE METHOD CALLED\n", FILE_APPEND);

        if ($this->isCsrfTokenValid('delete_objet_' . $objet->getId(), $request->request->get('_token'))) {
            $logger->log('Suppression', $objet);
            $em->remove($objet);
            $em->flush();

            return $this->redirectToRoute('app_objets');
        }

        return $this->redirectToRoute('app_objets');
    }

    #[Route('/mes-objets', name: 'app_mes_objets')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function mesObjets(ConnectedObjectRepository $repo): Response
    {
        $user = $this->getUser();
        $objets = $repo->findBy(['owner' => $user]);
        return $this->render('objets/mes_objets.html.twig', [
            'objets' => $objets
        ]);
    }
}
