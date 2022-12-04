<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('', name: 'app_profile_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $userRoles = $user->getRoles();

        if (in_array("ROLE_ADMIN", $userRoles)) {
            $this->redirectToRoute('app_profile_edit', ['id' => $user->getId()], Response::HTTP_PERMANENTLY_REDIRECT);
        }

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isSeller = $form->get('isSeller')->getData();

            if ($isSeller && !in_array('ROLE_SELLER', $userRoles)) {
                array_push($userRoles, 'ROLE_SELLER');
            } elseif (!$isSeller && in_array('ROLE_SELLER', $userRoles)) {
                if (($key = array_search('ROLE_SELLER', $userRoles)) !== false) {
                    unset($userRoles[$key]);
                }
            }

            $user->setRoles($userRoles);

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_profile_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
