<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileStudentController extends AbstractController
{
    #[Route('/profile/student', name: 'app_profile_student')]
    public function __invoke(): Response
    {
        return $this->render('profile/student.html.twig');
    }
}
