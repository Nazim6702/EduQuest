<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Enum\QuestionType;
use App\Form\QuizType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CreateQuizController extends AbstractController
{
    #[Route('/quiz/create', name: 'app_create_quiz')]
    #[IsGranted('ROLE_TEACHER')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $quiz = new Quiz();
        $quiz->setCreatedAt(new \DateTime());

        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $submittedQuestions = $request->request->all('questions');

            if ($submittedQuestions) {

                //dd($submittedQuestions);

                foreach ($submittedQuestions as $qIndex => $questionData) {
                    if (!isset($questionData['texte'], $questionData['type'])) continue;

                    $question = new Question();
                    $question->setTexte($questionData['texte']);
                    $question->setDuration((int) $questionData['duration']);
                    $question->setQuiz($quiz);

                    // Type
                    $type = $questionData['type'];
                    $question->setType(QuestionType::from($type));

                    // Traitement des réponses
                    if ($type === 'Open') {
                        $answerData = $questionData['answers'][0];
                        $answer = new Answer();
                        $answer->setTexte($answerData['texte']);
                        $answer->setIsCorrect(true);
                        $em->persist($answer);
                        $question->addAnswer($answer);
                    } elseif ($type === 'TRUE_FALSE') {
                        $correct = $questionData['correct'] === 'true';

                        $trueAnswer = new Answer();
                        $trueAnswer->setTexte('True');
                        $trueAnswer->setIsCorrect($correct);
                        $em->persist($trueAnswer);
                        $question->addAnswer($trueAnswer);

                        $falseAnswer = new Answer();
                        $falseAnswer->setTexte('False');
                        $falseAnswer->setIsCorrect(!$correct);
                        $em->persist($falseAnswer);
                        $question->addAnswer($falseAnswer);
                    } elseif ($type === 'QCM') {
                        $correctIndex = $questionData['correct'];
                        foreach ($questionData['answers'] as $index => $answerData) {
                            if (!is_array($answerData)) continue;
                            $answer = new Answer();
                            $answer->setTexte($answerData['texte']);
                            $answer->setIsCorrect((string) $index === (string) $correctIndex);
                            $em->persist($answer);
                            $question->addAnswer($answer);
                        }
                    }

                    $quiz->addQuestion($question);
                    $em->persist($question);
                }
            }

            $em->persist($quiz);
            $em->flush();

            $this->addFlash('success', 'Quiz enregistré avec succès !');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('create_quiz/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
