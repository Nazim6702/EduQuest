<?php
namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use App\Service\QuizCreationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CreateQuizController extends AbstractController
{
    #[Route('/quiz/create', name: 'app_create_quiz')]
    #[IsGranted('ROLE_TEACHER')]
    public function create(Request $request, QuizCreationService $creator): Response
    {
        $quiz = (new Quiz())->setCreatedAt(new \DateTime());
        $form = $this->createForm(QuizType::class, $quiz)->handleRequest($request);

        if ($form->isSubmitted()) {
            $creator->handleQuizCreation($quiz, $request->request->all('questions'));
            $this->addFlash('success', 'Quiz enregistré avec succès !');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('create_quiz/index.html.twig', ['form' => $form->createView()]);
    }
}
