<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DebateController extends AbstractController
{
    #[Route('/debate', name: 'app_debate')]
    public function index(): Response
    {
        return $this->render('debate/index.html.twig', [
            'controller_name' => 'DebateController',
        ]);
    }
}
