<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $themes = [
            ['icon' => '🔬', 'title' => 'Physique-Chimie', 'slug' => 'physique-chimie'],
            ['icon' => '📚', 'title' => 'Histoire', 'slug' => 'histoire'],
            ['icon' => '🌍', 'title' => 'Géographie', 'slug' => 'geographie'],
            ['icon' => '📕', 'title' => 'Français', 'slug' => 'francais'],
            ['icon' => '➗', 'title' => 'Maths', 'slug' => 'maths'],
            ['icon' => '🎭', 'title' => 'Culture Générale', 'slug' => 'culture-generale'],
            ['icon' => '🇬🇧', 'title' => 'Anglais', 'slug' => 'anglais'],
            ['icon' => '🌳', 'title' => 'S.V.T', 'slug' => 'svt'],
            ['icon' => '🧠', 'title' => 'Philosophie', 'slug' => 'philosophie'],
            ['icon' => '⚽', 'title' => 'Sports', 'slug' => 'sports'],
        ];

        return $this->render('home/index.html.twig', [
            'themes' => $themes,
        ]);
    }

    #[Route('/question-of-the-day', name: 'app_question_of_the_day')]
    public function questionOfTheDay(): Response
    {
        return $this->render('home/question_of_the_day.html.twig');
    }

    #[Route('/debate', name: 'app_debate')]
    public function debate(): Response
    {
        return $this->render('home/debate.html.twig');
    }

    #[Route('/progress', name: 'app_progress')]
    public function progress(): Response
    {
        return $this->render('home/progress.html.twig');
    }

    #[Route('/quiz', name: 'app_quiz')]
    public function quiz(): Response
    {
        $themes = [
            ['icon' => '🔬', 'title' => 'Physique-Chimie', 'slug' => 'physique-chimie'],
            ['icon' => '📚', 'title' => 'Histoire', 'slug' => 'histoire'],
            ['icon' => '🌍', 'title' => 'Géographie', 'slug' => 'geographie'],
            ['icon' => '📕', 'title' => 'Français', 'slug' => 'francais'],
            ['icon' => '➗', 'title' => 'Maths', 'slug' => 'maths'],
            ['icon' => '🎭', 'title' => 'Culture Générale', 'slug' => 'culture-generale'],
            ['icon' => '🇬🇧', 'title' => 'Anglais', 'slug' => 'anglais'],
            ['icon' => '🌳', 'title' => 'S.V.T', 'slug' => 'svt'],
            ['icon' => '🧠', 'title' => 'Philosophie', 'slug' => 'philosophie'],
            ['icon' => '⚽', 'title' => 'Sports', 'slug' => 'sports'],
        ];

        return $this->render('home/quiz.html.twig', [
            'themes' => $themes,
        ]);
    }

    #[Route('/quiz/{slug}', name: 'app_quiz_theme')]
    public function quizTheme(string $slug): Response
    {
        // Vous pouvez récupérer des données spécifiques au thème ici
        return $this->render('quiz/quiz_theme.html.twig', [
            'slug' => $slug,
        ]);
    }
}