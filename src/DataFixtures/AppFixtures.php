<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Enum\QuestionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $themes = ['Histoire', 'Sports', 'Physique-Chimie'];

        foreach ($themes as $theme) {
            $quiz = new Quiz();
            $quiz->setTitle($theme);
            $quiz->setDescription($faker->sentence());
            $quiz->setCreatedAt(new \DateTime());
            $quiz->setDuration($faker->numberBetween(10, 30));

            for ($i = 0; $i < 5; $i++) {
                $question = new Question();
                $question->setQuiz($quiz);
                $question->setTexte($faker->sentence());
                $question->setType($faker->randomElement([QuestionType::QCM, QuestionType::OPEN]));
                $question->setDuration($faker->numberBetween(30, 120));

                if ($question->getType() === 'QCM') {
                    for ($j = 0; $j < 4; $j++) {
                        $answer = new Answer();
                        $answer->setQuestion($question);
                        $answer->setTexte($faker->word());
                        // La première réponse est toujours correcte ici (flemme de faire des trucs random)
                        $answer->setIsCorrect($j === 0);
                        $manager->persist($answer);
                    }
                } else {
                    $answer = new Answer();
                    $answer->setQuestion($question);
                    $answer->setTexte($faker->word());
                    $answer->setIsCorrect(true);
                    $manager->persist($answer);
                }

                $manager->persist($question);
            }

            $manager->persist($quiz);
        }

        $manager->flush();
    }
}
