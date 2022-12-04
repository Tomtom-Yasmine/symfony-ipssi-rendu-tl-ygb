<?php

namespace App\Controller;

use App\Form\AddToCartType;
use App\Repository\ProductRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]

class ContentController extends AbstractController
{
    //Index
    #[Route('', name: 'app_home')]
    public function index(): Response {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // Products
    #[Route('/products', name: 'app_products')]
    public function indexProducts(ProductRepository $productRepository): Response {
        $products = $productRepository->findAllAvailable();

        $user = $this->getUser();
        if ($user) {
            foreach ($products as $product) {
                $form = $this->createForm(AddToCartType::class, null, [
                    'action' => $this->generateUrl('app_cart_add'),
                    'method' => 'POST',
                    'product' => $product,
                ]);
                $form->get('product_id')->setData($product->getId());
                $product->addToCartForm = $form->createView();
            }
        }

        return $this->render('content/products.html.twig', [
            'products' => $products
        ]);
    }
    
    //Article
    #[Route('/article', name: 'app_article')]
    public function indexArticles(ArticleRepository $articleRepository): Response {
        $articles = $articleRepository->findAll();

        return $this->render('content/products.html.twig', [
            'articles' => $articles,
        ]);
    }
    // #[Route('/content', name: 'app_content')]
    // public function index(): Response
    // {
    //     return $this->render('content/index.html.twig', [
    //         'controller_name' => 'ContentController',
    //     ]);
    // }
}
