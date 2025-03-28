<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328092710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du quiz "Culture générale" avec 5 questions et réponses.';
    }

    public function up(Schema $schema): void
    {
        // Insérer le quiz
        $this->addSql("INSERT INTO quiz (id, title, description, duration, created_at, category) VALUES 
            (1001, 'Culture générale', 'Un quiz qui mélange petites couches d humour et culture générale, parfait pour tester vos connaissances avant ou après un bon café.', 20, NOW(), 'culture générale')");

        // Q1 : Open
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2001, 1001, 'Quelle est la couleur du cheval blanc d’henri 4', 'Open', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3001, 2001, 'blanc', true)");

        // Q2 : Vrai/Faux
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2002, 1001, 'regis bob est le meilleur prof du S2', 'True/False', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3002, 2002, 'True', true),
            (3003, 2002, 'False', false)");

        // Q3 : QCM
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2003, 1001, 'quelle est la durée de la guerre de 100 ans', 'QCM', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3004, 2003, '107 ans', false),
            (3005, 2003, '100 ans', false),
            (3006, 2003, '116 ans', true),
            (3007, 2003, '86 ans', false)");

        // Q4 : Open
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2004, 1001, 'en UML, comment appelle t’on une agrégation avec cycle de vie dépendant : la classe parente est détruite lorsque la classe à laquelle est est liée disparaît. L\\'origine de cette association est représentée par un losange plein.', 'Open', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3008, 2004, 'Composition', true)");

        // Q5 : QCM
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2005, 1001, 'En quelle année à été publié le manifeste pour le développement agile de logiciels ?', 'QCM', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3009, 2005, '2014', false),
            (3010, 2005, '1978', false),
            (3011, 2005, '1992', false),
            (3012, 2005, '2001', true)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM answer WHERE question_id BETWEEN 2001 AND 2005');
        $this->addSql('DELETE FROM question WHERE quiz_id = 1001');
        $this->addSql('DELETE FROM quiz WHERE id = 1001');
    }
}
