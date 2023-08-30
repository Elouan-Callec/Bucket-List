<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_main')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/about-us', name: 'main_about_us')]
    public function about_us(): Response
    {
        return $this->render('main/about-us.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


}
