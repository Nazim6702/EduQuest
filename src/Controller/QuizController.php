<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    #[Route('/quiz/{slug}', name: 'app_quiz_theme')]
    public function quizTheme(string $slug): Response
    {
        // Vous pouvez récupérer des données spécifiques au thème ici
        return $this->render('quiz/quiz_theme.html.twig', [
            'slug' => $slug,
        ]);
    }
}