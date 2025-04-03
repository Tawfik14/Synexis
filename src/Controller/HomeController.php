<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(['/', '/home'], name: 'app_home')]
    public function index(): Response
    {
        $user = $this->getUser(); // ✅ Pas besoin d’injecter Security

        if ($user) {
            return $this->render('security/login_success.html.twig', [
                'user' => $user,
            ]);
        }

        return $this->render('home.html.twig');
    }
}

