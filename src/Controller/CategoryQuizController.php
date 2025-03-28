<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryQuizController extends AbstractController
{
    #[Route('/quizzes/category/{category}', name: 'app_quiz_by_category')]
    public function showByCategory(
        string $category,
        QuizRepository $quizRepository,
        PaginatorInterface $paginator,
        Request $request
    ) {
        $query = $quizRepository->createQueryBuilder('q')
            ->where('q.category = :category')
            ->setParameter('category', $category)
            ->orderBy('q.createdAt', 'DESC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 6 );

        return $this->render('quiz/by_category.html.twig', [
            'pagination' => $pagination,
            'category' => $category,
        ]);
    }
}
