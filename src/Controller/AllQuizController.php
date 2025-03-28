<?php
namespace App\Controller;

use App\Repository\QuizRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AllQuizController extends AbstractController
{
    #[Route('/quizzes', name: 'app_all_quizzes')]
    public function index(QuizRepository $quizRepo, PaginatorInterface $paginator, Request $request)
    {
        $query = $quizRepo->createQueryBuilder('q')
            ->orderBy('q.createdAt', 'DESC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),6);

        return $this->render('quiz/all.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
