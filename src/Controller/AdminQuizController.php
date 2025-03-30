<?php
namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use App\Service\QuizDeletionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/quiz', name: 'admin_quiz_')]
class AdminQuizController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(QuizRepository $quizRepository): Response
    {
        return $this->render('admin/quiz_list.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Quiz $quiz, QuizDeletionService $quizDeletion): Response
    {
        if ($this->isCsrfTokenValid('delete_quiz_' . $quiz->getId(), $request->request->get('_token'))) {
            $quizDeletion->delete($quiz);
            $this->addFlash('success', 'Quiz supprimé avec succès.');
        }

        return $this->redirectToRoute('admin_quiz_list');
    }
}
