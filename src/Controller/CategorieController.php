<?php

namespace App\Controller;
use App\Entity\Categorie;
use App\Form\CategorieType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    #[Route('/categories', name: 'app_categories')]
    public function listCategorie(CategorieRepository $repository)
    {
        $categories = $repository->findAll();
        return $this->render("categorie/listCategorie.html.twig", array("tabCategories" => $categories));
    }
    #[Route('/AddCategorie', name: 'app_AddCategorie')]
    public function AddCategorie(ManagerRegistry $doctrine, Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute("app_categories");
        }
        return $this->renderForm("categorie/addCategorie.html.twig", array("formCategorie" => $form));
    }
}
