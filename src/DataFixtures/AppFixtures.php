<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Admin;
use App\Entity\User;
use App\Entity\Quiz;
use App\Entity\Participation;
use App\Entity\Question;
use App\Entity\Answer;
use App\Enum\QuestionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $students = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new Student(); =
            $user->setName($faker->name)
                ->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setPseudo($faker->userName)
                ->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $students[] = $user;
        }

        $quizzes = [];
        for ($i = 0; $i < 5; $i++) {
            $quiz = new Quiz();
            $quiz->setTitle($faker->sentence)
                ->setDescription($faker->paragraph)
                ->setDuration(60)
                ->setCreatedAt(new \DateTime())
                ->setCategory($faker->word);
            $manager->persist($quiz);
            $quizzes[] = $quiz;

            for ($j = 0; $j < 3; $j++) {
                $question = new Question();
                $question->setTexte($faker->sentence)
                    ->setQuiz($quiz)
                    ->setDuration(30)
                    ->setType(QuestionType::from($faker->randomElement(['Open', 'True/False', 'QCM'])));
                $manager->persist($question);

                for ($k = 0; $k < 4; $k++) {
                    $answer = new Answer();
                    $answer->setTexte($faker->word)
                        ->setIsCorrect($k === 0)  
                        ->setQuestion($question);
                    $manager->persist($answer);
                }
            }
        }

        foreach ($students as $student) {
            foreach ($quizzes as $quiz) {
                $participation = new Participation();
                $participation->setUser($student)
                    ->setQuiz($quiz)
                    ->setDateParticipation($faker->dateTimeThisYear)
                    ->setScore($faker->numberBetween(0, 100));
                $manager->persist($participation);
            }
        }

        $manager->flush();
    }
}
