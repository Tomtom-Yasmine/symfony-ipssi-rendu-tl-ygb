<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function newUser(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
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
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // #[Route('/edit/{id}', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, User $user, UserRepository $userRepository): Response
    // {
    //     $currentUser = $this->getUser();
    //     $userRoles = $currentUser->getRoles();

    //     if (in_array("ROLE_ADMIN", $userRoles)) {
    //         $this->redirectToRoute('app_profile_edit', ['id' => $user->getId()], Response::HTTP_PERMANENTLY_REDIRECT);
    //     }

    //     $form = $this->createForm(ProfileType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $isSeller = $form->get('isSeller')->getData();

    //         if ($isSeller && !in_array('ROLE_SELLER', $userRoles)) {
    //             array_push($userRoles, 'ROLE_SELLER');
    //         } elseif (!$isSeller && in_array('ROLE_SELLER', $userRoles)) {
    //             if (($key = array_search('ROLE_SELLER', $userRoles)) !== false) {
    //                 unset($userRoles[$key]);
    //             }
    //         }

    //         $user->setRoles($userRoles);

    //         $userRepository->save($currentUser, true);

    //         return $this->redirectToRoute('app_profile_show', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('profile/edit.html.twig', [
    //         'user' => $currentUser,
    //         'form' => $form,
    //     ]);
    // }
}
