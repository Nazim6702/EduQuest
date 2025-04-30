<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Entity\User;
use App\Service\AnswerCheckerService;
use App\Service\ParticipationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class QuizSubmissionService
{
    public function __construct(
        private AnswerCheckerService $checker,
        private ParticipationService $participationService
    ) {}

    public function handleSubmission(
        Quiz $quiz,
        int $step,
        User $user,
        Request $request
    ): array {
        $question = $quiz->getQuestions()[$step] ?? null;
        if (!$question) {
            throw new \RuntimeException("Question introuvable à l'étape $step.");
        }

        $result = $this->checker->check($question, $request);

        $session = $request->getSession();
        $progressKey = 'quiz_progress_' . $quiz->getId();
        $progress = $session->get($progressKey, []);
        $progress[$question->getId()] = $result === true ? 'correct' : ($result === false ? 'wrong' : 'timeout');
        $session->set($progressKey, $progress);

        $isLast = !isset($quiz->getQuestions()[$step + 1]);

        if ($isLast) {
            $correctCount = count(array_filter($progress, fn($r) => $r === 'correct'));
            $this->participationService->recordParticipation($quiz, $user, $correctCount);
        }

        return [
            'status' => $progress[$question->getId()],
            'result' => $result,
            'nextStep' => $step + 1,
            'isLast' => $isLast,
        ];
    }
}
