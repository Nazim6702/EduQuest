<?php
namespace App\Controller;

use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class QuizExplorerController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz_explorer')]
    public function index(Request $request, QuizRepository $quizRepo, PaginatorInterface $paginator)
    {
        $search = $request->query->get('search');
        $category = $request->query->get('category');

        $qb = $quizRepo->createQueryBuilder('q');

        if ($search) {
            $qb->andWhere('q.title LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($category) {
            $qb->andWhere('q.category = :cat')
               ->setParameter('cat', $category);
        }

        $qb->orderBy('q.createdAt', 'DESC');

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('quiz/explorer.html.twig', [
            'pagination' => $pagination,
            'search' => $search,
            'category' => $category,
        ]);
    }
}
