<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription', methods: ['GET', 'POST'])]
    public function inscription(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    ): Response {
        $error = null; // Initialisation de la variable error

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $pseudo = $request->request->get('pseudo');
            $password = $request->request->get('password');
            $firstname = $request->request->get('firstname');
            $lastname = $request->request->get('lastname');
            $dob = $request->request->get('dob');
            $gender = $request->request->get('gender');

            
            if (!$email || !$pseudo || !$password || !$firstname || !$lastname || !$dob || !$gender) {
                $error = "Tous les champs sont obligatoires.";
            } else {
                
                $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
                if ($existingUser) {
                    $error = "L'email est déjà utilisé.";
                } else {
                    $existingUser = $entityManager->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]);
                    if ($existingUser) {
                        $error = "Le pseudo est déjà utilisé.";
                    } else {
                        
                        $user = new User();
                        $user->setEmail($email);
                        $user->setPseudo($pseudo);
                        $user->setPassword($passwordHasher->hashPassword($user, $password));
                        $user->setFirstname($firstname);
                        $user->setLastname($lastname);
                        $user->setDob(new \DateTime($dob));
                        $user->setGender($gender);

                        $entityManager->persist($user);
                        $entityManager->flush();

                        
                        return $this->redirectToRoute('confirmation');
                    }
                }
            }
        }

        return $this->render('inscription.html.twig', ['error' => $error]);
    }
}

