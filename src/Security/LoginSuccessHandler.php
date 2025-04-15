<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private RouterInterface $router;
    private EntityManagerInterface $em;

    public function __construct(RouterInterface $router, EntityManagerInterface $em)
    {
        $this->router = $router;
        $this->em = $em;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();
        $roles = $user->getRoles();

        //  Ajout direct d'1 point à la connexion
        $user->setPoints($user->getPoints() + 1);
        $this->em->persist($user);
        $this->em->flush();

        if (in_array('ROLE_ADMIN', $roles)) {
            return new RedirectResponse($this->router->generate('app_admin_dashboard'));
        }

        if (in_array('ROLE_ADVANCED', $roles)) {
            return new RedirectResponse($this->router->generate('app_advanced_dashboard'));
        }

        if (in_array('ROLE_USER', $roles)) {
            return new RedirectResponse($this->router->generate('app_user_dashboard'));
        }

        return new RedirectResponse($this->router->generate('app_home'));
    }
}
