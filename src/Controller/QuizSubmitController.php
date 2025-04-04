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
    public function __invoke(Quiz $quiz, int $step, Request $request, AnswerCheckerService $checker, ParticipationService $participationService): Response
    {
        $user = $this->getUser();
        $correctAnswersCount = 0;

        foreach ($quiz->getQuestions() as $question) {
            $result = $checker->check($question, $request);
            if ($result) {
                $correctAnswersCount++;
            }
        }

        $participationService->recordParticipation($quiz, $user, $correctAnswersCount);
        
        $session = $request->getSession();
        $progress = $session->get('quiz_progress_' . $quiz->getId(), []);
        $progress[$quiz->getId()] = $correctAnswersCount;
        $session->set('quiz_progress_' . $quiz->getId(), $progress);

        return $this->render('play_quiz/result.html.twig', [
            'status' => 'completed',
            'result' => $correctAnswersCount,
            'nextStep' => $step + 1,
            'quizId' => $quiz->getId(),
            'isLast' => !isset($quiz->getQuestions()[$step + 1])
        ]);
    }
}
