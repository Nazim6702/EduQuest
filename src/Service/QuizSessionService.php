<?php

namespace App\Service;

use App\Entity\Quiz;
use Symfony\Component\HttpFoundation\Request;

class QuizSessionService
{
    public function getStepData(Quiz $quiz, int $step, Request $request): ?array
    {
        $session = $request->getSession();
        $questions = $quiz->getQuestions()->toArray();

        if (!isset($questions[$step])) return null;

        if ($step === 0) {
            $session->remove('quiz_progress_' . $quiz->getId());
            $session->set('quiz_start_time_' . $quiz->getId(), time());
        }

        $startTime = $session->get('quiz_start_time_' . $quiz->getId()) ?? time();
        $elapsed = time() - $startTime;
        $remaining = max(0, $quiz->getDuration() * 60 - $elapsed);

        return [
            'quiz' => $quiz,
            'question' => $questions[$step],
            'step' => $step,
            'total' => count($questions),
            'globalRemaining' => $remaining,
            'progress' => $session->get('quiz_progress_' . $quiz->getId(), []),
        ];
    }
}
