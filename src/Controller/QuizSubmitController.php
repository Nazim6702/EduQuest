<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Service\AnswerCheckerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizSubmitController extends AbstractController
{
    #[Route('/quiz/{id}/submit/{step}', name: 'app_quiz_submit', methods: ['POST'])]
    public function __invoke(Quiz $quiz, int $step, Request $request, AnswerCheckerService $checker): Response
    {
        $questions = $quiz->getQuestions()->toArray();
        $question = $questions[$step];
        $result = $checker->check($question, $request);
        $session = $request->getSession();
        $progress = $session->get('quiz_progress_' . $quiz->getId(), []);
        $progress[$question->getId()] = $result === true ? 'correct' : ($result === false ? 'wrong' : 'timeout');
        $session->set('quiz_progress_' . $quiz->getId(), $progress);

        return $this->render('play_quiz/result.html.twig', [
            'status' => $progress[$question->getId()],
            'result' => $result,
            'nextStep' => $step + 1,
            'quizId' => $quiz->getId(),
            'isLast' => !isset($questions[$step + 1])
        ]);
    }
}
