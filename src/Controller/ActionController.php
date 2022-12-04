<?php

namespace App\Controller;

use App\Entity\CartProduct;
use App\Entity\Product;
use App\Form\AddToCartType;
use App\Repository\CartProductRepository;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActionController extends AbstractController
{
    #[Route('/addtocart', name: 'app_cart_add', methods: ['POST'])]
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
}
