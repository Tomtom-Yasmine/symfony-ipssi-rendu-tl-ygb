<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]

class AdminController extends AbstractController
{
    #[Route('/users', name: 'app_admin_user_index', methods: ['GET'])]
    public function indexUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function newUser(Request $request, UserRepository $userRepository): Response
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
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, User $user, UserRepository $userRepository): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $userRoles = $user->getRoles();
    //         $isSeller = $form->get('isSeller')->getData();
    //         $isAdmin = $form->get('isAdmin')->getData();

    //         if ($isSeller && !in_array('ROLE_SELLER', $userRoles)) {
    //             array_push($userRoles, 'ROLE_SELLER');
    //         } elseif (!$isSeller && in_array('ROLE_SELLER', $userRoles)) {
    //             if (($key = array_search('ROLE_SELLER', $userRoles)) !== false) {
    //                 unset($userRoles[$key]);
    //             }
    //         }

    //         $currentUser = $this->getUser()->getRoles();
    //         // dd($currentUser)

    //         if ($isAdmin && !in_array('ROLE_ADMIN', $userRoles)) {
    //             array_push($userRoles, 'ROLE_ADMIN');
    //         } elseif (!$isAdmin && in_array('ROLE_ADMIN', $userRoles)) {
    //             if (($key = array_search('ROLE_ADMIN', $userRoles)) !== false) {
    //                 unset($userRoles[$key]);
    //             }
    //         }

    //         $user->setRoles($userRoles);

    //         $userRepository->save($user, true);

    //         return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
    //     }
}
