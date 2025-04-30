<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Service\QuizSubmissionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizSubmitController extends AbstractController
{
    #[Route('/quiz/{id}/submit/{step}', name: 'app_quiz_submit', methods: ['POST'])]
    public function __invoke(
        Quiz $quiz,
        int $step,
        Request $request,
        QuizSubmissionService $submissionService
    ): Response {
        $user = $this->getUser();
        $data = $submissionService->handleSubmission($quiz, $step, $user, $request);

        return $this->render('play_quiz/result.html.twig', [
            'status' => $data['status'],
            'result' => $data['result'],
            'nextStep' => $data['nextStep'],
            'quizId' => $quiz->getId(),
            'isLast' => $data['isLast'],
        ]);
    }
}
