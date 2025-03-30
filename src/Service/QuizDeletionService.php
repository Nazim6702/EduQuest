<?php
namespace App\Service;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;

class QuizDeletionService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function delete(Quiz $quiz): void
    {
        $this->em->remove($quiz);
        $this->em->flush();
    }
}
