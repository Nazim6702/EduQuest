<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/quiz', name: 'admin_quiz_')]
class AdminQuizController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(QuizRepository $quizRepository)
    {
        $quizzes = $quizRepository->findAll();

        return $this->render('admin/quiz_list.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Quiz $quiz, EntityManagerInterface $em, Request $request)
    {
        if ($this->isCsrfTokenValid('delete_quiz_' . $quiz->getId(), $request->request->get('_token'))) {
            $em->remove($quiz);
            $em->flush();
            $this->addFlash('success', 'Quiz supprimé avec succès.');
        }

        return $this->redirectToRoute('admin_quiz_list');
    }
}
