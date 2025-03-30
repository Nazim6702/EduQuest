<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileTeacherController extends AbstractController
{
    #[Route('/profile/teacher', name: 'app_profile_teacher')]
    public function __invoke(): Response
    {
        return $this->render('profile/teacher.html.twig');
    }
}
