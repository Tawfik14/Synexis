<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserAdminType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/gestion/utilisateurs', name: 'app_users_manage')]
    public function list(Request $request, UserRepository $repo): Response
    {
        $query = $request->query->get('q');
        $roleFilter = $request->query->get('role');

        $users = $repo->findByFilters($query, $roleFilter);

        return $this->render('users/users_list.html.twig', [
            'users' => $users,
            'search' => $query,
            'roleFilter' => $roleFilter,
        ]);
    }

    #[Route('/gestion/utilisateur/modifier/{id}', name: 'app_user_edit')]
    public function edit(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles([$form->get('role')->getData()]);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_users_manage');
        }

        return $this->render('users/edit_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/gestion/utilisateur/supprimer/{id}', name: 'app_user_delete', methods: ['GET', 'POST'])]
    public function delete(User $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_users_manage');
    }
}
