<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/a-propos', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('link_footer/about.html.twig');
    }
}
