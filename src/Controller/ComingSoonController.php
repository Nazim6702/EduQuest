<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComingSoonController extends AbstractController
{
    #[Route('/coming-soon', name: 'app_undone')]
    public function __invoke(): Response
    {
        return $this->render('components/undone.html.twig');
    }
}
