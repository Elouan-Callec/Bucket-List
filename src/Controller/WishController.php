<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        /*$wishes = $wishRepository->findAllWishes();*/
        $wishes = $wishRepository->findBy(["isPublished" => true], ["dateCreated" => "DESC"]);

        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes
        ]);
    }

    #[Route('/detail/{wishId}', name: 'detail', requirements: ['id' => '\d+'])]
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

    #[Route('/new', name: 'new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $wish = new Wish();
        $wish
            ->setTitle("Make a lot of money")
            ->setDescription("Make a lot of money quickly")
            ->setAuthor("Elouan CALLEC")
            ->setIsPublished(true)
            ->setDateCreated(new \DateTime("now"));

        $entityManager->persist($wish);
        $entityManager->flush();

        return $this->render('wish/new.html.twig');
    }
}
