<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileAdminController extends AbstractController
{
    #[Route('/profile/admin', name: 'app_profile_admin')]
    public function __invoke(): Response
    {
        return $this->render('profile/admin.html.twig');
    }
}
