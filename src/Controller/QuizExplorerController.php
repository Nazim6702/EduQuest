<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizExplorerController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz_explorer')]
    public function index(Request $request, QuizRepository $quizRepo, PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search');
        $category = $request->query->get('category');

        $pagination = $paginator->paginate(
            $quizRepo->findByFilters($search, $category),
            $request->query->getInt('page', 1), 6);

        return $this->render('quiz/explorer.html.twig', [
            'pagination' => $pagination,
            'search' => $search,
            'category' => $category,
        ]);
    }
}
