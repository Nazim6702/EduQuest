<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileRedirectController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function __invoke(UserInterface $user): Response
    {
        return match ($user->getUserType()) {
            'student' => $this->redirectToRoute('app_profile_student'),
            'teacher' => $this->redirectToRoute('app_profile_teacher'),
            'admin' => $this->redirectToRoute('app_profile_admin'),
            default => $this->redirectToRoute('app_home'),
        };
    }
}
