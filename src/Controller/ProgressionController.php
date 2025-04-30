<?php

namespace App\Controller;

use App\Entity\Participation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/progression', name: 'app_progression')]
    public function index(): Response
    {
        $user = $this->getUser();
        $participations = $this->em->getRepository(Participation::class)->findBy(['user' => $user]);
        $enrichedParticipations = [];
        $categoryStats = [];

        foreach ($participations as $participation) {
            $quiz = $participation->getQuiz();
            $questionsCount = count($quiz->getQuestions());
            $rawScore = $participation->getScore();
            $enrichedParticipations[] = [
                'quiz' => $quiz,
                'score' => $rawScore,
                'totalQuestions' => $questionsCount,
                'date' => $participation->getDateParticipation(),
            ];
            $category = $quiz->getCategory();

            if (!isset($categoryStats[$category])) {
                $categoryStats[$category] = [
                    'count' => 0,
                    'totalNormalizedScore' => 0.0,
                ];
            }

            $categoryStats[$category]['count'] += 1;

            if ($questionsCount > 0) {
                $normalizedScore = ($rawScore / $questionsCount) * 10;
                $categoryStats[$category]['totalNormalizedScore'] += $normalizedScore;
            }
        }

        foreach ($categoryStats as $category => &$stats) {
            $stats['average'] = round($stats['totalNormalizedScore'] / $stats['count'], 2);
        }

        return $this->render('progression/index.html.twig', [
            'participations' => $enrichedParticipations,
            'categoryStats' => $categoryStats,
        ]);
    }
}
