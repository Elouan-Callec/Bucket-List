<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_main')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route('/about-us', name: 'main_about_us')]
    public function about_us(): Response
    {
        return $this->render('main/about-us.html.twig');
    }
}
