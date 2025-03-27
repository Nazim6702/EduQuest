<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Enum\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlayQuizController extends AbstractController
{
    #[Route('/quiz/{id}', name: 'app_play_quiz')]
    public function index(int $id, EntityManagerInterface $em): Response
    {
        $quiz = $em->getRepository(Quiz::class)->find($id);

        if (!$quiz) {
            throw $this->createNotFoundException('Quiz non trouvé');
        }

        return $this->render('play_quiz/index.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    #[Route('/quiz/{id}/play/{step}', name: 'app_quiz_play')]
    public function playStep(int $id, int $step, Request $request, EntityManagerInterface $em): Response
    {
        $quiz = $em->getRepository(Quiz::class)->find($id);
        if (!$quiz) {
            throw $this->createNotFoundException();
        }

        $questions = $quiz->getQuestions()->toArray();
        if (!isset($questions[$step])) {
            return $this->redirectToRoute('app_quiz_results', ['id' => $id]);
        }

        $question = $questions[$step];

        return $this->render('play_quiz/play.html.twig', [
            'quiz' => $quiz,
            'question' => $question,
            'step' => $step,
            'total' => count($questions)
        ]);
    }

    #[Route('/quiz/{id}/submit/{step}', name: 'app_quiz_submit', methods: ['POST'])]
    public function submit(int $id, int $step, Request $request, EntityManagerInterface $em): Response
    {
        $quiz = $em->getRepository(Quiz::class)->find($id);
        $questions = $quiz->getQuestions()->toArray();
        $question = $questions[$step];

        $result = false;

        if ($question->getType() === QuestionType::QCM || $question->getType() === QuestionType::TRUE_FALSE) {
            $selectedId = $request->request->get('answer');
            $selectedAnswer = $em->getRepository(Answer::class)->find($selectedId);
            if ($selectedAnswer && $selectedAnswer->isCorrect()) {
                $result = true;
            }
        } elseif ($question->getType() === QuestionType::OPEN) {
            $userInput = trim($request->request->get('answer_text'));
            foreach ($question->getAnswers() as $answer) {
                if (strtolower($userInput) === strtolower($answer->getTexte())) {
                    $result = true;
                    break;
                }
            }
        }

        return $this->render('play_quiz/result.html.twig', [
            'result' => $result,
            'nextStep' => $step + 1,
            'quizId' => $id,
            'isLast' => !isset($questions[$step + 1])
        ]);
    }

}
