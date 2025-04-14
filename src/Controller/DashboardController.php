<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use App\Service\UserLogger;


use App\Service\HistoryLogger;

use App\Entity\DeleteRequest;
use App\Entity\DeleteObjetRequest;
use App\Repository\DeleteObjetRequestRepository;
use App\Repository\DeleteRequestRepository;
use App\Repository\ServiceRepository;
use App\Entity\Service;
use App\Form\ServiceType;
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
    public function index( ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        return $this->render('security/login_success.html.twig');
}
    #[Route('/profil', name: 'app_profil')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profil( ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        return $this->render('profil.html.twig');
     }
    #[Route('/profil/edit', name: 'app_profil_edit')]
    

#[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editProfil(Request $request, EntityManagerInterface $em, FormFactoryInterface $formFactory, UserPasswordHasherInterface $passwordHasher, \App\Service\UserLogger $userLogger, ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
                $user->setPassword($hashedPassword);
            }

        $userLogger->log($this->getUser(), 'Modification', 'Profil utilisateur');
            $user->setPoints($user->getPoints() + 1);
        $em->persist($user);
        $em->flush();
        UserLogger::logToDatabase($this->getUser(), 'Modification', 'Profil utilisateur', $doctrine, $logger);

            
            // Ajout direct de points pour modification profil
            
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
    public function info(Request $request, InfoPublicRepository $repo, ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
    public function gestion( ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        if (!$this->isGranted('ROLE_COMPLEXE') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('gestion.html.twig');
        }
    #[Route('/objets', name: 'app_objets')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function objets(ConnectedObjectRepository $repo, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $objets = $repo->findAll();

        return $this->render('objets/index.html.twig', [
            'objets' => $objets,
        ]);
}
    #[Route('/gestion/stats', name: 'app_gestion_stats')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function stats(ConnectedObjectRepository $repository, ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
    public function adminPanel( ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        return $this->render('admin_panel.html.twig');
}
    #[Route('/dashboard/admin', name: 'app_admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminDashboard( ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        return $this->render('admin/admin_dashboard.html.twig');
        }
    #[Route('/dashboard/advanced', name: 'app_advanced_dashboard')]
    #[IsGranted('ROLE_ADVANCED')]
    public function advancedDashboard( ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        return $this->render('advanced/advanced_dashboard.html.twig');
        }
    #[Route('/dashboard/user', name: 'app_user_dashboard')]
#[IsGranted('ROLE_USER')]
    public function userDashboard( ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        return $this->render('user/user_dashboard.html.twig');
}
    #[Route('/objets/nouveau', name: 'app_objets_new')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function newObjet(Request $request, EntityManagerInterface $em, \App\Service\UserLogger $userLogger, ManagerRegistry $doctrine, LoggerInterface $logger, HistoryLogger $historyLogger): Response
    {
        $objet = new ConnectedObject();
        $form = $this->createForm(ConnectedObjectType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
        $user = $this->getUser();
        $action = $objet->getId() ? 'Modification' : 'Ajout';
        $userLogger->log($this->getUser(), $action, $objet->getName());
        $historyLogger->log($objet, $this->getUser(), $em);

        $em->persist($objet);
        $user = $this->getUser();
        $user = $this->getUser();
        $user->setPoints($user->getPoints() + 1);
        $em->persist($user);
        $em->flush();
        UserLogger::logToDatabase($this->getUser(), 'Ajout', $objet->getName(), $doctrine, $logger);
        
        
            return $this->redirectToRoute('app_objets');
        }

        return $this->render('objets/new.html.twig', [
            'form' => $form->createView(),
        ]);
        }
    #[Route('/objets/{id}/edit', name: 'app_objets_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editObjet(Request $request, ConnectedObject $objet, EntityManagerInterface $em, \App\Service\UserLogger $userLogger, ManagerRegistry $doctrine, LoggerInterface $logger, HistoryLogger $historyLogger): Response
    {
        $form = $this->createForm(ConnectedObjectType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $user = $this->getUser();
        $action = $objet->getId() ? 'Modification' : 'Ajout';
        $historyLogger->log($objet, $this->getUser(), $em);

        $userLogger->log($this->getUser(), $action, $objet->getName());
        $user = $this->getUser();
        $user = $this->getUser();
        $user->setPoints($user->getPoints() + 1);
        $em->persist($user);
        $em->flush();
        UserLogger::logToDatabase($this->getUser(), 'Modification', $objet->getName(), $doctrine, $logger);
        
        
            return $this->redirectToRoute('app_objets');
        }

        return $this->render('objets/edit.html.twig', [
            'form' => $form->createView(),
            'objet' => $objet,
        ]);
        }
    #[Route('/objets/{id}/delete', name: 'app_objets_delete', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deleteObjet(Request $request, ConnectedObject $objet, EntityManagerInterface $em, \App\Service\UserLogger $userLogger, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        if ($this->isCsrfTokenValid('delete_objet_' . $objet->getId(), $request->request->get('_token'))) {
            $name = $objet->getName();
        $user = $this->getUser();
        if ($user instanceof \Symfony\Component\Security\Core\User\UserInterface) {
        }
            $user = $this->getUser();
        $em->persist($user);
        $em->remove($objet);
        $em->flush();
        UserLogger::logToDatabase($this->getUser(), 'Suppression', $objet->getName(), $doctrine, $logger);
        $this->addFlash('success', 'Objet supprimé avec succès.');
        }
        

        $user = $this->getUser();
        $user->setPoints($user->getPoints() + 1);
        $em->persist($user);
        $em->flush();
        

        return $this->redirectToRoute('app_objets');
        }
#[Route('/mes-objets', name: 'app_connected_objects')]
public function mesObjets(ObjetRepository $objetRepository, Security $security, ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    $user = $security->getUser();
    $objets = $objetRepository->findBy(['user' => $user]);

    return $this->render('objets/mes_objets.html.twig', [
        'objets' => $objets,
    ]);
    }
#[Route('/objets', name: 'app_all_objects')]
public function allObjects(ObjetRepository $objetRepository, Request $request, ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    $objets = $objetRepository->findAll();

    return $this->render('objets/all_objects.html.twig', [
        'objets' => $objets,
    ]);
    }
#[Route('/objets-tous', name: 'app_objets')]
public function redirectToAllObjects( ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    return $this->redirectToRoute('app_all_objects');
    }
#[Route('/objets/navigation', name: 'app_connected_navigation')]
public function connectedNavigation( ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    return $this->render('objets_navigation.html.twig');
    }
#[Route('/utilisateurs', name: 'app_user_directory')]
public function userDirectory(Request $request, UserRepository $userRepository, ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
public function objetsHome( ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    return $this->render('objets_home.html.twig');
    }
#[Route('/objets/liste', name: 'app_objets_list')]
public function objetsList(ObjetRepository $objetRepository, Request $request, ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    $objets = $objetRepository->findAll();

    return $this->render('index.html.twig', [
        'objets' => $objets,
    ]);
}
#[Route('/objets/statistiques', name: 'app_objets_stats')]
public function objetsStats(ObjetRepository $objetRepository, ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
public function extraStats( ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
public function dashboard( ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    return $this->render('admin-pannel-dashboard.html.twig');
    }
#[Route('/admin/users', name: 'admin_users')]
public function listUsers(EntityManagerInterface $em, ManagerRegistry $doctrine, LoggerInterface $logger): Response
{
    $users = $em->getRepository(User::class)->findAll();

    return $this->render('users/users_list.html.twig', [
        'users' => $users,
    ]);
}
#[Route('/objets/{id}/historique', name: 'app_objet_historique')]
public function historiqueObjet(int $id, ObjectLogRepository $logRepo, ObjetRepository $objetRepo, ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
    public function logs(\App\Repository\UserLogRepository $userLogRepository, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $logs = $userLogRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('logs.html.twig', [
            'logs' => $logs,
        ]);
        }
    #[Route('/admin/users', name: 'admin_users')]
    public function usersList(Request $request, \App\Repository\UserRepository $userRepository, ManagerRegistry $doctrine, LoggerInterface $logger): Response
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
    #[Route('/mes-services', name: 'app_my_services')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function myServices(ServiceRepository $serviceRepo, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $user = $this->getUser();
        $services = $serviceRepo->findBy(['owner' => $user]);
        return $this->render('services/mes_services.html.twig', ['services' => $services]);
        }
    #[Route('/tous-les-services', name: 'app_all_services')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function allServices(ServiceRepository $serviceRepo, Request $request, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $services = $serviceRepo->findAll(); // Ajoutez filtrage si nécessaire
        return $this->render('services/all_services.html.twig', ['services' => $services]);
}
    #[Route('/services/nouveau', name: 'app_services_new')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]

    public function newService(Request $request, EntityManagerInterface $em, ServiceType $formType, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $service = new Service();
        $form = $this->createForm(get_class($formType), $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setOwner($this->getUser());
            $em->persist($service);
            $user = $this->getUser();
        $user = $this->getUser();
        $user->setPoints($user->getPoints() + 1);
        $em->persist($user);
        $em->flush();
        UserLogger::logToDatabase($this->getUser(), 'Ajout', $service->getName(), $doctrine, $logger);
        
        
            return $this->redirectToRoute('app_all_services');
        }

        return $this->render('services/new_services.html.twig', ['form' => $form->createView()]);
        }
    #[Route('/services/{id}/modifier', name: 'app_services_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]

    public function editService(Request $request, EntityManagerInterface $em, Service $service, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
        $user = $this->getUser();
        $user->setPoints($user->getPoints() + 1);
        $em->persist($user);
        $em->flush();
        UserLogger::logToDatabase($this->getUser(), 'Modification', $service->getName(), $doctrine, $logger);
        
        
            return $this->redirectToRoute('app_all_services');
        }

        return $this->render('services/edit_services.html.twig', ['form' => $form->createView(), 'service' => $service]);
        }
    #[Route('/services/{id}/supprimer', name: 'app_services_delete', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]

    public function deleteService(Request $request, EntityManagerInterface $em, Service $service, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        if ($this->isCsrfTokenValid('delete_service_' . $service->getId(), $request->request->get('_token'))) {
            $user = $this->getUser();
        $em->persist($user);
        $em->remove($service);
            $user = $this->getUser();
        
        }
        $user = $this->getUser();
        $user->setPoints($user->getPoints() + 1);
        $em->persist($user);
        $em->flush();
        UserLogger::logToDatabase($this->getUser(), 'Suppression', $service->getName(), $doctrine, $logger);
        

        return $this->redirectToRoute('app_my_services');
        }
    #[Route('/services', name: 'app_services')]
    public function servicesIndex(ServiceRepository $serviceRepo, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $services = $serviceRepo->findAll();
        return $this->render('services/index_services.html.twig', [
            'services' => $services,
        ]);
        }
#[Route('/logs/utilisateur', name: 'app_user_logs')]
    #[IsGranted('ROLE_ADMIN')]
    public function userLogs(\App\Repository\UserLogRepository $userLogRepository, ManagerRegistry $doctrine, LoggerInterface $logger): Response
    {
        $logs = $userLogRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('logs/user_logs.html.twig', [
            'logs' => $logs,
        ]);
}
#[Route('/services/{id}/demande-suppression', name: 'app_services_delete_request', methods: ['POST'])]
public function deleteRequest(Request $request, Service $service, EntityManagerInterface $entityManager, Security $security): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADVANCED');

    if ($this->isCsrfTokenValid('delete_service_request_' . $service->getId(), $request->request->get('_token'))) {
        $deleteRequest = new DeleteRequest();
        $deleteRequest->setService($service);
        $deleteRequest->setUser($security->getUser());
        $deleteRequest->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($deleteRequest);
        $entityManager->flush();

        $this->addFlash('notice', 'Demande de suppression envoyée pour le service : ' . $service->getName());
    }

    return $this->redirectToRoute('app_services');
    }
#[Route('/admin/delete-requests', name: 'app_admin_delete_requests')]
public function viewDeleteRequests(
    DeleteRequestRepository $deleteRequestRepository,
    DeleteObjetRequestRepository $deleteObjetRequestRepository
): Response {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $serviceRequests = $deleteRequestRepository->findBy([], ['createdAt' => 'DESC']);
    $objetRequests = $deleteObjetRequestRepository->findBy([], ['createdAt' => 'DESC']);

    return $this->render('delete_requests.html.twig', [
        'serviceRequests' => $serviceRequests,
        'objetRequests' => $objetRequests,
    ]);
}

#[Route('/objets/{id}', name: 'app_objets_info', methods: ['GET'])]
public function show(ConnectedObject $objet): Response
{
    return $this->render('show.html.twig', [
        'objet' => $objet,
    ]);
}

#[Route('/objets/{id}/demande-suppression', name: 'app_objets_delete_request', methods: ['POST'])]
public function deleteObjetRequest(Request $request, ConnectedObject $objet, EntityManagerInterface $entityManager, Security $security): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADVANCED');

    if ($this->isCsrfTokenValid('delete_objet_request_' . $objet->getId(), $request->request->get('_token'))) {
        $requestObj = new DeleteObjetRequest();
        $requestObj->setObjet($objet);
        $requestObj->setUser($security->getUser());
        $requestObj->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($requestObj);
        $entityManager->flush();

        $this->addFlash('notice', "Demande de suppression envoyée pour l'objet : " . $objet->getName());
    }

    return $this->redirectToRoute('app_objets');
}

#[Route('/demandes-suppression', name: 'app_delete_requests')]
public function showDeleteRequests(
    DeleteServiceRequestRepository $serviceRepo,
    DeleteObjetRequestRepository $objetRepo
): Response {
    $serviceRequests = $serviceRepo->findBy([], ['createdAt' => 'DESC']);
    $objetRequests = $objetRepo->findBy([], ['createdAt' => 'DESC']);

    return $this->render('delete_requests.html.twig', [
        'serviceRequests' => $serviceRequests,
        'objetRequests' => $objetRequests,
    ]);
}

}
