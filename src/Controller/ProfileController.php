<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(UserInterface $user): Response
    {
        switch ($user->getUserType()) {
            case 'student':
                return $this->redirectToRoute('app_profile_student');
            case 'teacher':
                return $this->redirectToRoute('app_profile_teacher');
            case 'admin':
                return $this->redirectToRoute('app_profile_admin');
            default:
                return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/profile/student', name: 'app_profile_student')]
    public function student(): Response
    {
        return $this->render('profile/student.html.twig');
    }

    #[Route('/profile/teacher', name: 'app_profile_teacher')]
    public function teacher(): Response
    {
        return $this->render('profile/teacher.html.twig');
    }

    #[Route('/profile/admin', name: 'app_profile_admin')]
    public function admin(): Response
    {
        return $this->render('profile/admin.html.twig');
    }
}
