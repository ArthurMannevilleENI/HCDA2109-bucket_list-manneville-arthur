<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function home(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/legal-stuff', name: 'app_legal_stuff')]
    public function legalStuff(): Response
    {
        return $this->render('legalStuff.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/about-us', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('main/about-us.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
