<?php

namespace App\Service;

use App\Entity\Participation;
use App\Entity\Quiz;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ParticipationService
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function recordParticipation(Quiz $quiz, User $user, float $score): void
    {
        $existingParticipation = $this->em->getRepository(Participation::class)->findOneBy([
            'quiz' => $quiz,
            'user' => $user,
        ]);

        if (!$existingParticipation) {
            $participation = new Participation();
            $participation->setUser($user);
            $participation->setQuiz($quiz);
            $participation->setDateParticipation(new \DateTime());
            $participation->setScore($score);

            $this->em->persist($participation);
            $this->em->flush();
        }
    }
}
