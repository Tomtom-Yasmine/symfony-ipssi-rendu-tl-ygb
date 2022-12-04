<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Form\UserType;
use App\Form\ArticleFilterType;
use App\Form\ProductFilterType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]

class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(Request $request, ArticleRepository $articleRepository, ProductRepository $productRepository, UserRepository $userRepository): Response
    {
        /*         $roleChecker = $this->container->get('security.authorization_checker');
        if ($roleChecker->isGranted('ROLE_ADMIN') && !$roleChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_home');
        } */
        $articlesCount = count($articleRepository->findAll());
        $productsCount = count($productRepository->findAll());
        $usersCount = count($userRepository->findAll());

        $articleForm = $this->createForm(ArticleFilterType::class);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $limit = $articleForm->get('limit')->getData();
            $author = $articleForm->get('author')->getData();
            $authorId = $author->getId();

            return $this->redirectToRoute('app_admin_articles', [
                "limit" => $limit,
                "author" => $authorId
            ]);
        }

        $productForm = $this->createForm(ProductFilterType::class);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $limit = $productForm->get('limit')->getData();
            $seller = $productForm->get('seller')->getData();
            $category = $productForm->get('category')->getData();
            $sellerId = $seller->getId();
            $categoryId = $category->getId();

            return $this->redirectToRoute('app_admin_products', [
                "limit" => $limit,
                "seller" => $sellerId,
                "category" => $categoryId
            ]);
        }

        return $this->renderForm('admin/index.html.twig', [
            "articlesCount" => $articlesCount,
            "productsCount" => $productsCount,
            "usersCount" => $usersCount,
            "articleForm" => $articleForm,
            "productForm" => $productForm
        ]);
    }
    #[Route('/users', name: 'app_admin_user_index', methods: ['GET'])]
    public function indexUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function newUser(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, CartRepository $cartRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRoles = [];
            if ($form->get('isSeller')->getData()) {
                array_push($userRoles, 'ROLE_SELLER');
            }
            if ($form->get('isAdmin')->getData()) {
                array_push($userRoles, 'ROLE_ADMIN');
            }
            $user->setRoles($userRoles);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $cart = new Cart();
            $cart->setOwner($user);
            $cartRepository->save($cart, true);
            
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/articles/{limit}/{author}', name: 'app_admin_articles')]
    public function getArticles(ArticleRepository $articleRepository, $limit, $author)
    {
        $articles = $articleRepository->findBy(
            ['authors' => [$author]],
            ['createdAt' => 'DESC'],
            $limit
        );
        // $articles = $articleRepository->findByCreatedDate($limit, $author);

        return $this->render('admin/articles.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/products/{limit}/{seller}/{category}', name: 'app_admin_products')]
    public function getProducts(ProductRepository $productRepository, $limit, $seller, $category)
    {

        $products = $productRepository->findByCreatedDate($limit, $seller, $category);

        return $this->render('admin/products.html.twig', [
            'products' => $products
        ]);
    }
}
