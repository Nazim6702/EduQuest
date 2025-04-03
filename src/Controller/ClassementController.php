<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassementController extends AbstractController
{
    #[Route('/classement', name: 'app_classement')]
    public function index(): Response
    {
        $classements = [
            ['nom' => 'Jean Dupont', 'score' => 1500],
            ['nom' => 'Marie Durand', 'score' => 1450],
            ['nom' => 'Luc Martin', 'score' => 1400],
        ];

        return $this->render('link_footer/classement.html.twig', [
            'classements' => $classements,
        ]);
    }
}
