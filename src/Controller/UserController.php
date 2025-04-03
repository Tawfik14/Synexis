<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($request->isMethod('POST')) {
            $user = new User();

            $user->setLastname($request->request->get('lastname'));
            $user->setFirstname($request->request->get('firstname'));
            $user->setDob(new \DateTime($request->request->get('dob')));
            $user->setGender($request->request->get('gender'));
            $user->setEmail($request->request->get('email'));
            $user->setPseudo($request->request->get('pseudo'));

            // 🔐 Gestion du code d'accès pour déterminer le rôle
            $code = $request->request->get('access_code');

            switch ($code) {
                case 'SYN-ADM-01':
                    $user->setRoles(['ROLE_ADMIN']);
                    break;
                case 'SYN-ADV-02':
                    $user->setRoles(['ROLE_ADVANCED']);
                    break;
                case 'SYN-USER-03':
                    $user->setRoles(['ROLE_USER']);
                    break;
                default:
                    $this->addFlash('error', 'Code d\'accès invalide.');
                    return $this->redirectToRoute('app_register');
            }

            $password = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm-password');

            if ($password !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('app_register');
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig');
    }
    #[Route('/profil', name: 'app_profil')]
    public function monProfil(): Response
    {
        return $this->render('profil.html.twig');
    }

}