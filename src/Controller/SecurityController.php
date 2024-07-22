<?php

// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request): Response
    {
        // This method is only needed for custom logic if needed
        return $this->render('security/login.html.twig');
    }

    #[Route('/login_check', name: 'app_login_check')]
    public function loginCheck(Request $request, Security $security): RedirectResponse
    {
        // Cette route est utilisée par Symfony pour vérifier les informations de connexion.
        // Vous n'avez pas besoin de définir une méthode spécifique pour cela.
        // Symfony gère cela automatiquement via la configuration de sécurité.
        return $this->redirectToRoute('app_home');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        // Cette méthode est appelée lors de la déconnexion.
        // Symfony gère automatiquement la déconnexion.
        // Vous pouvez rediriger ou afficher un message ici si nécessaire.
        return $this->redirectToRoute('app_login');
    }
}
