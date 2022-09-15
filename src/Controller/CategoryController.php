<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'app_category_')]
class CategoryController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ){}

    #[Route('/list', name: 'list')]
    public function listAllCategories(): Response
    {
        $categories = $this->doctrine->getRepository(Category::class)->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function createCategory(Request $request): Response
    {
        $category = new Category();

        $categoryForm = $this->createForm(CategoryFormType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid())
        {
            $categoryFormDatas = $categoryForm->getData();

            $category->setName($categoryFormDatas->getName());

            $em = $this->doctrine->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash("success", "La catégorie à bien été ajouté");

            return $this->redirectToRoute("app_category_list");
        }

        return $this->render('category/create.html.twig', [
            'categoryForm' => $categoryForm->createView(),
        ]);
    }
}
