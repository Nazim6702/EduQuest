<?php

namespace App\Controller;

use App\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizStartController extends AbstractController
{
    #[Route('/quiz/{id}', name: 'app_play_quiz')]
    public function __invoke(Quiz $quiz): Response
    {
        return $this->render('play_quiz/index.html.twig', ['quiz' => $quiz]);
    }
}
