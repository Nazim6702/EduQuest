<?php

namespace App\Controller;

use App\Service\ProgressionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressionController extends AbstractController
{
    #[Route('/progression', name: 'app_progression')]
    public function index(ProgressionService $progressionService): Response
    {
        $user = $this->getUser();
        $data = $progressionService->getUserProgression($user);

        return $this->render('progression/index.html.twig', [
            'participations' => $data['participations'],
            'categoryStats' => $data['categoryStats'],
        ]);
    }
}
