<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
// use App\Entity\Product;
// use App\Form\ProductType;


#[Route('/admin', name: 'app_admin')]
class AdminController extends AbstractController
{
    #[Route('/products', name: '_products')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/product/add', name: '_product_add')]
    public function new(Request $request)
    {
        // $product = new Product();
        // $form = $this->createForm(ProductType::class, $product);

        // $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($product);
        //     $entityManager->flush();
        //     return $this->redirectToRoute('admin_products');
        // }

        // return $this->render('admin/product_new.html.twig', ['form' => $form->createView()]);
    }

}
