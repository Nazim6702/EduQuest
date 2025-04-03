<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/laisser-un-avis', name: 'app_avis')]
    public function index(): Response
    {
        return $this->render('link_footer/avis.html.twig');
    }
}
