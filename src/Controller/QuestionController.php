<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/question-du-jour', name: 'question_of_the_day')]
    public function index(QuestionRepository $questionRepository): Response
    {
        $question = $questionRepository->findQuestionOfTheDay();

        return $this->render('question/of_the_day.html.twig', [
            'question' => $question,
        ]);
    }
}
