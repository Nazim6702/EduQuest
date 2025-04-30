<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Service\AnswerCheckerService;
use App\Service\ParticipationService;
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
        AnswerCheckerService $checker,
        ParticipationService $participationService
    ): Response {
        $user = $this->getUser();
        $question = $quiz->getQuestions()[$step] ?? null;

        if (!$question) {
            throw $this->createNotFoundException("Question introuvable pour l'étape $step.");
        }

        $result = $checker->check($question, $request);
        $session = $request->getSession();
        $progress = $session->get('quiz_progress_' . $quiz->getId(), []);
        $progress[$question->getId()] = $result === true ? 'correct' : ($result === false ? 'wrong' : 'timeout');
        $session->set('quiz_progress_' . $quiz->getId(), $progress);
        $isLast = !isset($quiz->getQuestions()[$step + 1]);

        if ($isLast) {
            $correctAnswers = array_filter($progress, fn($value) => $value === 'correct');
            $score = count($correctAnswers);
            $participationService->recordParticipation($quiz, $user, $score);
        }

        return $this->render('play_quiz/result.html.twig', [
            'status' => $progress[$question->getId()],
            'result' => $result,
            'nextStep' => $step + 1,
            'quizId' => $quiz->getId(),
            'isLast' => $isLast
        ]);
    }
}
