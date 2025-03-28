<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(QuizRepository $quizRepository): Response
    {

        $quizzes = $quizRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('home/index.html.twig', [
            'quizzes' => $quizzes
        ]);

    }

    #[Route('/coming-soon', name: 'app_undone')]
    public function undone(): Response
    {
        return $this->render('components/undone.html.twig');
    }
}