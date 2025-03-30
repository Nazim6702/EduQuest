<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Service\QuizSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizStepController extends AbstractController
{
    #[Route('/quiz/{id}/play/{step}', name: 'app_quiz_play')]
    public function __invoke(Quiz $quiz, int $step, Request $request, QuizSessionService $sessionService): Response
    {
        $sessionData = $sessionService->getStepData($quiz, $step, $request);
        if ($sessionData === null) {
            return $this->redirectToRoute('app_quiz_results', ['id' => $quiz->getId()]);
        }

        return $this->render('play_quiz/play.html.twig', $sessionData);
    }
}
