<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ){}

    #[Route('/wish/list', name: 'app_wish_list')]
    public function listWish(): Response
    {
        $wishes = $this->doctrine->getRepository(Wish::class)->findBy(["isPublished" => true]);

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
        ]);
    }

    #[Route('/wish/{wishId}/details', name: 'app_wish_details')]
    public function detailsWish(int $wishId): Response
    {
        $wish = $this->doctrine->getRepository(Wish::class)
            ->findOneBy(["id" => $wishId]);

        return $this->render('wish/details.html.twig', [
            "wish" => $wish,
        ]);
    }
}
