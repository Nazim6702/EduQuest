<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328093937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du quiz "Géographie avancée" avec 7 questions difficiles.';
    }

    public function up(Schema $schema): void
    {
        // Insertion du quiz
        $this->addSql("INSERT INTO quiz (id, title, description, duration, created_at, category) VALUES 
            (1003, 'Géographie avancée', 'Un quiz qui met à l épreuve vos connaissances les plus pointues sur la géographie du monde entier.', 14, NOW(), 'géographie')");

        // Q1 : QCM - plus grand lac d'Afrique
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2020, 1003, 'Quel est le plus grand lac d\\'Afrique par superficie ?', 'QCM', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3030, 2020, 'Lac Victoria', true),
            (3031, 2020, 'Lac Tanganyika', false),
            (3032, 2020, 'Lac Malawi', false),
            (3033, 2020, 'Lac Tchad', false)");

        // Q2 : Vrai/Faux - Atacama
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2021, 1003, 'Le désert d\\'Atacama, situé au Chili, est considéré comme le désert le plus aride du monde.', 'True/False', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3034, 2021, 'True', true),
            (3035, 2021, 'False', false)");

        // Q3 : QCM - plus longue chaîne de montagne
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2022, 1003, 'Quelle chaîne de montagnes est considérée comme la plus longue du monde ?', 'QCM', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3036, 2022, 'Les Andes', true),
            (3037, 2022, 'L Himalaya', false),
            (3038, 2022, 'Les Rocheuses', false),
            (3039, 2022, 'Les Alpes', false)");

        // Q4 : Open - capitale de la Mongolie
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2023, 1003, 'Quelle est la capitale de la Mongolie ?', 'Open', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3040, 2023, 'Oulan-Bator', true)");

        // Q5 : Vrai/Faux - Amazonie traverse 3 pays
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2024, 1003, 'Le fleuve Amazone traverse trois pays : le Pérou, la Colombie et le Brésil.', 'True/False', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3041, 2024, 'True', true),
            (3042, 2024, 'False', false)");

        // Q6 : QCM - seul pays doublement enclavé
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2025, 1003, 'Parmi ces pays, lequel est le seul à être doublement enclavé ?', 'QCM', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3043, 2025, 'Népal', false),
            (3044, 2025, 'Mongolie', false),
            (3045, 2025, 'Ouzbékistan', true),
            (3046, 2025, 'Philippines', false)");

        // Q7 : Open - point culminant Afrique
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2026, 1003, 'Quel est le point culminant du continent africain ?', 'Open', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3047, 2026, 'Kilimandjaro', true)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
