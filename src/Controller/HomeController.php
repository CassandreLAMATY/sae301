<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;


class HomeController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur déjà connecté,

            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        } else {
            // Utilisateur non connecté,
            return $this->redirectToRoute('app_login');
        }
    }
}
