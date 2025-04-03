<?php

namespace App\Service;

use App\Entity\Participation;
use App\Entity\User;
use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;

class ParticipationService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function recordParticipation(Quiz $quiz, User $user, float $score): void
    {
        $participation = new Participation();
        $participation->setUser($user)
                      ->setQuiz($quiz)
                      ->setDateParticipation(new \DateTime())
                      ->setScore($score);
        $this->em->persist($participation);
        $this->em->flush();
    }

    public function recordTotalScore(Quiz $quiz, User $user, float $totalScore): void
    {
        $participation = $this->em->getRepository(Participation::class)->findOneBy([
            'user' => $user,
            'quiz' => $quiz
        ]);

        if ($participation) {
            $participation->setScore($totalScore);
            $this->em->flush();
        } else {
            $this->recordParticipation($quiz, $user, $totalScore); 
        }
    }
}
