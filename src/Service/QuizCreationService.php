<?php
namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Enum\QuestionType;
use Doctrine\ORM\EntityManagerInterface;

class QuizCreationService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function handleQuizCreation(Quiz $quiz, array $submittedQuestions): void
    {
        foreach ($submittedQuestions as $questionData) {
            if (!isset($questionData['texte'], $questionData['type'])) continue;

            $question = new Question();
            $question->setTexte($questionData['texte']);
            $question->setDuration((int)$questionData['duration']);
            $question->setType(QuestionType::from($questionData['type']));
            $question->setQuiz($quiz);

            $this->addAnswers($question, $questionData);
            $quiz->addQuestion($question);

            $this->em->persist($question);
        }

        $this->em->persist($quiz);
        $this->em->flush();
    }

    private function addAnswers(Question $question, array $data): void
    {
        $type = $data['type'];

        if ($type === 'Open') {
            $answer = new Answer();
            $answer->setTexte($data['answers'][0]['texte'] ?? '');
            $answer->setIsCorrect(true);
            $this->em->persist($answer);
            $question->addAnswer($answer);
        }

        if ($type === 'True/False') {
            foreach ($data['answers'] as $answerData) {
                $answer = new Answer();
                $answer->setTexte($answerData['texte']);
                $answer->setIsCorrect(filter_var($answerData['isCorrect'], FILTER_VALIDATE_BOOLEAN));
                $this->em->persist($answer);
                $question->addAnswer($answer);
            }
        }

        if ($type === 'QCM') {
            $correctIndex = $data['answers']['correctIndex'] ?? null;
            foreach ($data['answers'] as $index => $answerData) {
                if (!is_numeric($index)) continue;
                $answer = new Answer();
                $answer->setTexte($answerData['texte']);
                $answer->setIsCorrect((string)$index === (string)$correctIndex);
                $this->em->persist($answer);
                $question->addAnswer($answer);
            }
        }
    }
}
