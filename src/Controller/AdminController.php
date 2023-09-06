<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        $isAdmin = $this->isGranted("ROLE_ADMIN");
        if (!$isAdmin) {
            $this->createNotFoundException("This page is only for admins");
        }
        return $this->render('admin/index.html.twig');
    }
}
