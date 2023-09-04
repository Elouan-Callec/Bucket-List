<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(["isPublished" => true], ["dateCreated" => "DESC"]);

        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes
        ]);
    }

    #[Route('/detail/{wishId}', name: 'detail', requirements: ['wishId' => '\d+'])]
    public function detail(int $wishId, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($wishId);

        if (!$wish) {
            throw $this->createNotFoundException("Oops ! Wish not found !");
        }

        return $this->render('wish/detail.html.twig', [
            "wish" => $wish
        ]);
    }

    #[Route('/add-wish', name: 'add-wish')]
    public function add_wish(EntityManagerInterface $entityManager, Request $request): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash("success", "Idea successfully added !");

            return $this->redirectToRoute("wish_detail", ['wishId' => $wish->getId()]);
        }

        return $this->render('wish/add.html.twig', [
            'wishForm' => $wishForm
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(int $id, WishRepository $wishRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $wish = $wishRepository->find($id);
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setDateUpdated(new \DateTime('now'));

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash("success", "Idea successfully updated !");

            return $this->redirectToRoute("wish_detail", ['wishId' => $wish->getId()]);
        }

        return $this->render('wish/edit.html.twig', [
            'wishForm' => $wishForm
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(): Response
    {
        return $this->render('wish/delete.html.twig');
    }
}
