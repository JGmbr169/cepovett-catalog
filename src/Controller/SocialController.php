<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Service\FacebookService;

class SocialController extends AbstractController
{
    private $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    #[Route('/post-to-facebook/{$id}', name: 'app_product_post_fb', methods: ['GET'])]
    public function postToFacebook(Request $request, EntityManagerInterface $entityManager, FacebookService $facebookService): Response
    {
        $product = $entityManager->getRepository(Product::class)->findById(
            ['id' => (int) $request->query->get('id') ]
        );

        if($product) {
            $this->facebookService->postToFacebook($product[0]->getName(), "Venez découvrir notre nouveau produit " . $product[0]->getName(), "https://www.cepovett.com/");
            return new Response('Post published to Facebook.');
        }
    }

}
