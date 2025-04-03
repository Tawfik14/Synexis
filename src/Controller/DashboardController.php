<?php

namespace App\Controller;

use App\Repository\ObjectLogRepository;use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\ObjetRepository;

use App\Entity\ConnectedObject;
use App\Entity\User;
use App\Form\ConnectedObjectType;
use App\Form\UserType;
use App\Repository\ConnectedObjectRepository;
use App\Repository\InfoPublicRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response
    {
        return $this->render('security/login_success.html.twig');
    }


    #[Route('/profil', name: 'app_profil')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profil(): Response
    {
        return $this->render('profil.html.twig');
    }

    #[Route('/profil/edit', name: 'app_profil_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editProfil(Request $request, EntityManagerInterface $em, FormFactoryInterface $formFactory, UserPasswordHasherInterface $passwordHasher, \App\Service\UserLogger $userLogger): Response
    {
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            throw $this->createAccessDeniedException();
        }

        $form = $formFactory->create(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();
            if ($password) {
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
            }

            $userLogger->log('Modification profil');
        $em->flush();

            return $this->render('profil_modification.html.twig', [
                'form' => $form->createView(),
                'profilModifie' => true,
            ]);
        }

        return $this->render('profil_modification.html.twig', [
            'form' => $form->createView(),
            'profilModifie' => false,
        ]);
    }

    #[Route('/info', name: 'app_info')]
    public function info(Request $request, InfoPublicRepository $repo): Response
    {
        $categorie = $request->query->get('categorie');
        $departement = $request->query->get('departement');
        $results = $repo->findByFilters($categorie, $departement);

        return $this->render('info/index.html.twig', [
            'results' => $results,
            'selected_categorie' => $categorie,
            'selected_departement' => $departement
        ]);
    }

    #[Route('/gestion', name: 'app_gestion')]
    public function gestion(): Response
    {
        if (!$this->isGranted('ROLE_COMPLEXE') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('gestion.html.twig');
    }

    #[Route('/objets', name: 'app_objets')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function objets(ConnectedObjectRepository $repo): Response
    {
        $objets = $repo->findAll();

        return $this->render('objets/index.html.twig', [
            'objets' => $objets,
        ]);
    }

    #[Route('/gestion/stats', name: 'app_gestion_stats')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function stats(ConnectedObjectRepository $repository): Response
    {
        $types = $repository->countByType();
        $statuses = $repository->countByStatus();

        return $this->render('gestion/stats.html.twig', [
            'types' => $types,
            'statuses' => $statuses,
        ]);
    }



    #[Route('/admin-panel', name: 'app_admin_panel')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminPanel(): Response
    {
        return $this->render('admin_panel.html.twig');
    }

    #[Route('/dashboard/admin', name: 'app_admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminDashboard(): Response
    {
        return $this->render('admin/admin_dashboard.html.twig');
    }

    #[Route('/dashboard/advanced', name: 'app_advanced_dashboard')]
    #[IsGranted('ROLE_ADVANCED')]
    public function advancedDashboard(): Response
    {
        return $this->render('advanced/advanced_dashboard.html.twig');
    }

    #[Route('/dashboard/user', name: 'app_user_dashboard')]
#[IsGranted('ROLE_USER')]
    public function userDashboard(): Response
    {
        return $this->render('user/user_dashboard.html.twig');
    }

    #[Route('/objets/nouveau', name: 'app_objets_new')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function newObjet(Request $request, EntityManagerInterface $em, \App\Service\UserLogger $userLogger): Response
    {
        $objet = new ConnectedObject();
        $form = $this->createForm(ConnectedObjectType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logger->log('Ajout', $objet);
        $em->persist($objet);
            $userLogger->log('Modification profil');
        $em->flush();
            return $this->redirectToRoute('app_objets');
        }

        return $this->render('objets/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/objets/{id}/edit', name: 'app_objets_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editObjet(Request $request, ConnectedObject $objet, EntityManagerInterface $em, \App\Service\UserLogger $userLogger): Response
    {
        $form = $this->createForm(ConnectedObjectType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userLogger->log('Modification profil');
        $em->flush();
            return $this->redirectToRoute('app_objets');
        }

        return $this->render('objets/edit.html.twig', [
            'form' => $form->createView(),
            'objet' => $objet,
        ]);
    }

    #[Route('/objets/{id}/delete', name: 'app_objets_delete', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deleteObjet(Request $request, ConnectedObject $objet, EntityManagerInterface $em, \App\Service\UserLogger $userLogger, \App\Service\ObjectLogger $logger): Response
    {
        if ($this->isCsrfTokenValid('delete_objet_' . $objet->getId(), $request->request->get('_token'))) {
            $name = $objet->getName();
        $logger->log('Suppression', $objet, $name);
            $em->remove($objet);
            $userLogger->log('Modification profil');
        $em->flush();
        }

        return $this->redirectToRoute('app_objets');
    }


#[Route('/mes-objets', name: 'app_connected_objects')]
public function mesObjets(ObjetRepository $objetRepository, Security $security): Response
{
    $user = $security->getUser();
    $objets = $objetRepository->findBy(['user' => $user]);

    return $this->render('objets/mes_objets.html.twig', [
        'objets' => $objets,
    ]);
}

#[Route('/objets', name: 'app_all_objects')]
public function allObjects(ObjetRepository $objetRepository, Request $request): Response
{
    $objets = $objetRepository->findAll();

    return $this->render('objets/all_objects.html.twig', [
        'objets' => $objets,
    ]);
}

#[Route('/objets-tous', name: 'app_objets')]
public function redirectToAllObjects(): Response
{
    return $this->redirectToRoute('app_all_objects');
}


#[Route('/objets/navigation', name: 'app_connected_navigation')]
public function connectedNavigation(): Response
{
    return $this->render('objets_navigation.html.twig');
}








#[Route('/utilisateurs', name: 'app_user_directory')]
public function userDirectory(Request $request, UserRepository $userRepository): Response
{
    $search = $request->query->get('search');

    $users = $search
        ? $userRepository->createQueryBuilder('u')
            ->where('u.pseudo LIKE :s OR u.email LIKE :s')
            ->setParameter('s', '%' . $search . '%')
            ->getQuery()
            ->getResult()
        : $userRepository->findAll();

    return $this->render('user/directory.html.twig', [
        'users' => $users,
        'search' => $search,
    ]);
}


#[Route('/objets_home', name: 'app_objets_home')]
public function objetsHome(): Response
{
    return $this->render('objets_home.html.twig');
}


#[Route('/objets/liste', name: 'app_objets_list')]
public function objetsList(ObjetRepository $objetRepository, Request $request): Response
{
    $objets = $objetRepository->findAll();

    return $this->render('index.html.twig', [
        'objets' => $objets,
    ]);
}


#[Route('/objets/statistiques', name: 'app_objets_stats')]
public function objetsStats(ObjetRepository $objetRepository): Response
{
    $objets = $objetRepository->findAll();

    $types = [];
    $statuses = [];

    foreach ($objets as $objet) {
        $types[$objet->getType()] = ($types[$objet->getType()] ?? 0) + 1;
        $statuses[$objet->getStatus()] = ($statuses[$objet->getStatus()] ?? 0) + 1;
    }

    $typesData = [];
    foreach ($types as $type => $count) {
        $typesData[] = ['type' => $type, 'count' => $count];
    }

    $statusesData = [];
    foreach ($statuses as $status => $count) {
        $statusesData[] = ['status' => $status, 'count' => $count];
    }

    return $this->render('gestion/stats.html.twig', [
        'types' => $typesData,
        'statuses' => $statusesData,
    ]);
}
#[Route('/admin/stats-extra', name: 'stats_extra')]
public function extraStats(): Response
{
    $locations = [
        ['location' => 'Paris', 'count' => 5],
        ['location' => 'Lyon', 'count' => 3],
    ];

    $brands = [
        ['brand' => 'Synexis', 'count' => 6],
        ['brand' => 'Autre', 'count' => 2],
    ];

    return $this->render('gestion/stats_extra.html.twig', [
        'locations' => $locations,
        'brands' => $brands,
    ]);
}

#[Route('/admin', name: 'admin_dashboard')]
public function dashboard(): Response
{
    return $this->render('admin-pannel-dashboard.html.twig');
}
#[Route('/admin/users', name: 'admin_users')]
public function listUsers(EntityManagerInterface $em): Response
{
    $users = $em->getRepository(User::class)->findAll();

    return $this->render('users/users_list.html.twig', [
        'users' => $users,
    ]);
}


#[Route('/objets/{id}/historique', name: 'app_objet_historique')]
public function historiqueObjet(int $id, ObjectLogRepository $logRepo, ObjetRepository $objetRepo): Response
{
    $objet = $objetRepo->find($id);
    if (!$objet) {
        throw $this->createNotFoundException('Objet non trouvé.');
    }

    $logs = $logRepo->findByObjetId($id);

    return $this->render('historique_objet.html.twig', [
        'objet' => $objet,
        'logs' => $logs,
    ]);
}



    #[Route('/admin/logs', name: 'admin_logs')]
    public function logs(\App\Repository\UserLogRepository $userLogRepository): Response
    {
        $logs = $userLogRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('logs.html.twig', [
            'logs' => $logs,
        ]);
    }
    #[Route('/admin/users', name: 'admin_users')]
    public function usersList(Request $request, \App\Repository\UserRepository $userRepository): Response
    {
        $search = $request->query->get('q', '');
        $roleFilter = $request->query->get('role', '');

        $users = $userRepository->findByFilters($search, $roleFilter);

        return $this->render('users/users_list.html.twig', [
            'users' => $users,
            'search' => $search,
            'roleFilter' => $roleFilter,
        ]);
    }

}
