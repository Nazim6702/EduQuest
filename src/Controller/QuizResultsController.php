<?php

namespace App\Controller;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizResultsController extends AbstractController
{
    #[Route('/quiz/{id}/results', name: 'app_quiz_results')]
    public function __invoke(Quiz $quiz, Request $request): Response
    {
        $progress = $request->getSession()->get('quiz_progress_' . $quiz->getId(), []);
        return $this->render('play_quiz/results.html.twig', [
            'quiz' => $quiz,
            'progress' => $progress
        ]);
    }
}
