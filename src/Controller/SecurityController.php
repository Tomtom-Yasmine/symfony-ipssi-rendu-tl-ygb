<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/deleteaccount/{id}', name: 'app_delete_account', methods: ['POST'])]
    public function deleteAccount(Request $request, User $user, UserRepository $userRepository): Response
    {
        $isCurrentUser = ($this->getUser() === $user);
        if ($isCurrentUser || $this->isGranted('ROLE_ADMIN')) {
            if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
                if ($isCurrentUser) {
                    $session = $request->getSession();
                    $session = new Session();
                    $session->invalidate();
                }
                $userRepository->remove($user, true);
                if ($this->isGranted('ROLE_ADMIN')) {
                    return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
                }
            }
        }
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
