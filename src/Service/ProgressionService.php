<?php

namespace App\Service;

use App\Entity\Participation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ProgressionService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function getUserProgression(User $user): array
    {
        $participations = $this->em
            ->getRepository(Participation::class)
            ->findBy(['user' => $user]);

        $enriched = [];
        $categoryStats = [];

        foreach ($participations as $participation) {
            $quiz = $participation->getQuiz();
            $totalQuestions = count($quiz->getQuestions());
            $rawScore = $participation->getScore();

            $enriched[] = [
                'quiz' => $quiz,
                'score' => $rawScore,
                'totalQuestions' => $totalQuestions,
                'date' => $participation->getDateParticipation(),
            ];

            $category = $quiz->getCategory();
            if (!isset($categoryStats[$category])) {
                $categoryStats[$category] = [
                    'count' => 0,
                    'totalNormalizedScore' => 0.0,
                ];
            }

            $categoryStats[$category]['count']++;

            if ($totalQuestions > 0) {
                $normalized = ($rawScore / $totalQuestions) * 10;
                $categoryStats[$category]['totalNormalizedScore'] += $normalized;
            }
        }

        foreach ($categoryStats as $cat => &$data) {
            $data['average'] = round($data['totalNormalizedScore'] / $data['count'], 2);
        }

        return [
            'participations' => $enriched,
            'categoryStats' => $categoryStats,
        ];
    }
}
