<?php

namespace App\Controller;

use App\Entity\CartProduct;
use App\Form\AddToCartType;
use App\Repository\ProductRepository;
use App\Repository\ArticleRepository;
use App\Repository\CartProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]

class ContentController extends AbstractController
{
    // Index
    #[Route('', name: 'app_home', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response {
        return $this->render('home/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['createdAt' => 'DESC'], 3),
        ]);
    }

    // Products
    #[Route('/products', name: 'app_product_index', methods: ['GET'])]
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

        return $this->render('content/product/index.html.twig', [
            'products' => $products
        ]);
    }

    // Cart
    #[Route('/cart', name: 'app_cart_show', methods: ['GET'])]
    public function showCart(): Response {
        $user = $this->getUser();
        if (! $user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('content/cart/show.html.twig', [
            'cart' => $user->getCart(),
        ]);
    }

    #[Route('/cart/add', name: 'app_cart_add', methods: ['POST'])]
    public function addToCart(Request $request, ProductRepository $productRepository, CartProductRepository $cartProductRepository): Response
    {
        $user = $this->getUser();
        if (! $user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(AddToCartType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartProducts = $user->getCart()->getProducts();
            
            $data = $form->getData();
            $product = $productRepository->find($data['product_id']);
            if (! $product) {
                throw $this->createNotFoundException('Product not found');
            }

            $matchingCartProducts = array_filter($cartProducts->toArray(), function ($cartProduct) use ($product, $data) {
                return
                    $cartProduct->getProduct()->getId() === $product->getId()
                    && $cartProduct->getColor() === $data['color'];
            });

            if (count($matchingCartProducts) > 0) {
                $cartProduct = $matchingCartProducts[0];
                $cartProduct->setQuantity($cartProduct->getQuantity() + $data['quantity']);
            } else {
                $cartProduct = new CartProduct();
                $cartProduct->setProduct($product);
                $cartProduct->setColor($data['color']);
                $cartProduct->setQuantity($data['quantity']);
                $cartProduct->setCart($user->getCart());
            }
            $cartProductRepository->save($cartProduct, true);
        }

        return $this->redirectToRoute('app_cart_show');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['GET'])]
    public function removeFromCart(CartProduct $cartProduct, CartProductRepository $cartProductRepository): Response
    {
        $user = $this->getUser();
        if (! $user) {
            return $this->redirectToRoute('app_login');
        }

        $cartProductRepository->remove($cartProduct, true);

        return $this->redirectToRoute('app_cart_show');
    }
    
    // Article
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
