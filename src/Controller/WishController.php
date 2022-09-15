<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishFormType;
use App\Repository\WishRepository;
use App\Util\Censurator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'app_wish_')]
class WishController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private Censurator $censurator
    ){}

    #[Route('/list', name: 'list')]
    public function listWish(): Response
    {
        $wishes = $this->doctrine->getRepository(Wish::class)->findBy(["isPublished" => true]);

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
        ]);
    }

    #[Route('/{wishId}/details', name: 'details')]
    public function detailsWish(int $wishId): Response
    {
        $wish = $this->doctrine->getRepository(Wish::class)
            ->findOneBy(["id" => $wishId]);

        return $this->render('wish/details.html.twig', [
            "wish" => $wish,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function createWish(Request $request): Response
    {
        $wish = new Wish();

        $wishForm = $this->createForm(WishFormType::class, $wish,
        [
            "connectedUsername" => $this->getUser()->getUsername()
        ]);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid())
        {
            $wishFormDatas = $wishForm->getData();

            $wish->setTitle($wishFormDatas->getTitle());
            $wish->setAuthor($wishFormDatas->getAuthor());
            $wish->setDescription($this->censurator->purify($wishFormDatas->getDescription()));
            $wish->setIsPublished($wishFormDatas->isPublished());
            $wish->setDateCreated(new \DateTime());

            $em = $this->doctrine->getManager();
            $em->persist($wish);
            $em->flush();

            $this->addFlash("success", "Le voeu à bien été ajouté");

            return $this->redirectToRoute("app_wish_list");
        }

        return $this->render('wish/create.html.twig', [
            "wishForm" => $wishForm->createView(),
        ]);
    }
}
