<?php

namespace App\Controller;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
