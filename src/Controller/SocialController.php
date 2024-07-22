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
use App\Service\TwitterService;
use App\Service\LinkedinService;

class SocialController extends AbstractController
{
    private $facebookService;
    private $twitterService;
    private $linkedinService;

    public function __construct(FacebookService $facebookService, TwitterService $twitterService, LinkedinService $linkedinService)
    {
        $this->facebookService = $facebookService;
        $this->twitterService = $twitterService;
        $this->linkedinService = $linkedinService;
    }

    #[Route('/post-to-facebook/{$id}', name: 'app_product_post_fb', methods: ['GET'])]
    public function postToFacebook(Request $request, EntityManagerInterface $entityManager, FacebookService $facebookService): Response
    {
        $product = $entityManager->getRepository(Product::class)->findById(
            ['id' => (int) $request->get('id') ]
        );
        if($product) {
            $response = $this->facebookService->postToFacebook($product[0]->getName(), "Venez découvrir notre nouveau produit " . $product[0]->getName(), "https://www.cepovett.com/");
            return new Response($response);
        }
    }

    #[Route('/post-to-twitter/{id}', name: 'app_product_post_tw', methods: ['GET'])]
    public function postToTwitter(Request $request, EntityManagerInterface $entityManager, TwitterService $twitterService): Response
    {
        $product = $entityManager->getRepository(Product::class)->findById(
            ['id' => (int) $request->get('id') ]
        );
        if($product) {
            $response = $this->twitterService->publishTweet($product[0]->getName(), "Venez découvrir notre nouveau produit " . $product[0]->getName());
            return new Response($response);
        }
    }

    #[Route('/post-to-linkedin/{id}', name: 'app_product_post_lk')]
    public function postToLinkedin(Request $request, EntityManagerInterface $entityManager, LinkedinService $linkedinService): Response
    {
        $product = $entityManager->getRepository(Product::class)->findById(
            ['id' => (int) $request->get('id') ]
        );
        $result = $this->linkedinService->postUpdate($product[0]->getName(), 'TODO_ACCESS_TOKEN', "Venez découvrir notre nouveau produit " . $product[0]->getName());
        return new Response('Post result: ' . json_encode($result));
    }

}
