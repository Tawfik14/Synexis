<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdvancedController extends AbstractController
{
    #[IsGranted('ROLE_ADVANCED')]
    #[Route('/advanced', name: 'advanced_dashboard')]
    public function index(): Response
    {
        return $this->render('advanced/advanced_dashboard.html.twig');
    }
}
