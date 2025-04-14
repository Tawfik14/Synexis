<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class ContactController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('contact.html.twig'); // ✅ correspond à ton fichier
    }

    #[Route('/contact/send', name: 'app_contact_send', methods: ['POST'])]
    public function send(Request $request, EntityManagerInterface $entityManager): Response
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $messageContent = $request->request->get('message');

        $role = null;
        $user = $this->security->getUser();
        if ($user) {
            $roles = $user->getRoles();
            $role = $roles[0] ?? 'ROLE_USER';
        }

        $message = new ContactMessage();
        $message->setName($name);
        $message->setEmail($email);
        $message->setMessage($messageContent);
        $message->setCreatedAt(new \DateTimeImmutable());
        $message->setRole($role);

        $entityManager->persist($message);
        $entityManager->flush();

        $this->addFlash('success', 'Votre message a bien été envoyé.');
        return $this->redirectToRoute('app_contact');
    }

    #[Route('/admin/messages', name: 'admin_messages')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $messages = $entityManager->getRepository(ContactMessage::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('message.html.twig', [
            'messages' => $messages,
        ]);
    }
}

