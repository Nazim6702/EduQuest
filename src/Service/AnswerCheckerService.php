<?php

namespace App\Service;

use App\Entity\Question;
use App\Enum\QuestionType;
use App\Entity\Answer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AnswerCheckerService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function check(Question $question, Request $request): bool|null
    {
        if ($question->getType() === QuestionType::QCM || $question->getType() === QuestionType::TRUE_FALSE) {
            $selectedId = $request->request->get('answer');
            if ($selectedId !== null) {
                $selectedAnswer = $this->em->getRepository(Answer::class)->find($selectedId);
                return $selectedAnswer && $selectedAnswer->isCorrect();
            }
            return null;
        }

        if ($question->getType() === QuestionType::OPEN) {
            $userInput = trim($request->request->get('answer_text'));
            foreach ($question->getAnswers() as $answer) {
                if (strtolower($userInput) === strtolower($answer->getTexte())) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }
}
