<?php

namespace App\DataFixtures;

use App\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $themes = [
            [
                'title' => 'Physique-Chimie',
                'slug' => 'physique-chimie',
                'icon' => '🔬',
                'description' => 'Découvrez les lois de la nature, de l’atome aux réactions chimiques.',
            ],
            [
                'title' => 'Histoire',
                'slug' => 'histoire',
                'icon' => '📚',
                'description' => 'Voyagez à travers les époques pour comprendre notre passé commun.',
            ],
            [
                'title' => 'Géographie',
                'slug' => 'geographie',
                'icon' => '🌍',
                'description' => 'Explorez les continents, les paysages et les enjeux géopolitiques.',
            ],
            [
                'title' => 'Français',
                'slug' => 'francais',
                'icon' => '📕',
                'description' => 'Maîtrisez la langue de Molière, ses règles et sa beauté littéraire.',
            ],
            [
                'title' => 'Maths',
                'slug' => 'maths',
                'icon' => '➗',
                'description' => 'Résolvez des énigmes logiques et développez votre esprit analytique.',
            ],
            [
                'title' => 'Culture Générale',
                'slug' => 'culture-generale',
                'icon' => '🎭',
                'description' => 'Testez vos connaissances dans tous les domaines du savoir.',
            ],
            [
                'title' => 'Anglais',
                'slug' => 'anglais',
                'icon' => '🇬🇧',
                'description' => 'Améliorez votre maîtrise de la langue internationale par excellence.',
            ],
            [
                'title' => 'S.V.T',
                'slug' => 'svt',
                'icon' => '🌳',
                'description' => 'Comprenez les êtres vivants et les phénomènes biologiques.',
            ],
            [
                'title' => 'Philosophie',
                'slug' => 'philosophie',
                'icon' => '🧠',
                'description' => 'Réfléchissez aux grandes questions existentielles.',
            ],
            [
                'title' => 'Sports',
                'slug' => 'sports',
                'icon' => '⚽',
                'description' => 'Défiez vos connaissances dans les disciplines sportives.',
            ],
        ];

        foreach ($themes as $data) {
            $quiz = new Quiz();
            $quiz->setTitle($data['title']);
            $quiz->setSlug($data['slug']);
            $quiz->setIcon($data['icon']);
            $quiz->setDescription($data['description']);
            $quiz->setDuration(15); //Est ce que c'est en seconde ou en minutes ?
            $quiz->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($quiz);
        }

        $manager->flush();
    }
}
