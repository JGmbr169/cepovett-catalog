<?php

// src/Controller/CatalogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

#[Route('/catalog', name: 'app_catalog')]
class CatalogController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager, Security $security): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $page_range = $this->getParameter('knp_paginator.page_range');

        $datas = $entityManager->getRepository(Product::class)->findBy(
            ['active' => 1]
        );

        $products = $paginator->paginate(
            $datas, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            $page_range // Nombre de résultats par page
        );

        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'CatalogController',
            'products' => $products,
            'user' => $security->getUser()

        ]);
    }

}
