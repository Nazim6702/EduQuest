<?php

namespace App\Controller;

use App\Service\ParticipationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressionController extends AbstractController
{
    #[Route('/progression', name: 'app_progression')]
    public function index(ParticipationService $participationService): Response
    {
        $user = $this->getUser();

        if (!$user || $user->getUserType() !== 'student') {
            return $this->redirectToRoute('app_home');
        }

        $participations = $this->getDoctrine()
            ->getRepository(Participation::class)
            ->findBy(['user' => $user]);

        $averageScore = $participationService->getAverageScore($user);

        return $this->render('progression/index.html.twig', [
            'participations' => $participations,
            'averageScore' => $averageScore
        ]);
    }
}
