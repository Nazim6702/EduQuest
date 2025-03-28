<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328093239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du quiz "Sport" avec 7 questions sur les JO, le foot, le tennis, etc.';
    }

    public function up(Schema $schema): void
    {
        // Insertion du quiz
        $this->addSql("INSERT INTO quiz (id, title, description, duration, created_at, category) VALUES 
            (1002, 'Sport', 'Un quiz conçu pour les fans de sport : saurez-vous briller ?', 20, NOW(), 'sport')");

        // Q1 : Open
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2010, 1002, 'Dans quelle ville se sont déroulés les premiers Jeux Olympiques modernes en 1896 ?', 'Open', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3015, 2010, 'Athènes', true)");

        // Q2 : QCM
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2011, 1002, 'Quel pays a remporté la Coupe du Monde de football en 2018 ?', 'QCM', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3016, 2011, 'Brésil', false),
            (3017, 2011, 'France', true),
            (3018, 2011, 'Allemagne', false),
            (3019, 2011, 'Argentine', false)");

        // Q3 : True/False
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2012, 1002, 'Usain Bolt détient toujours le record du monde du 100 mètres.', 'True/False', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3020, 2012, 'True', true),
            (3021, 2012, 'False', false)");

        // Q4 : Open
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2013, 1002, 'Quel est le seul pays à avoir participé à toutes les éditions de la Coupe du Monde de football ?', 'Open', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3022, 2013, 'Brésil', true)");

        // Q5 : QCM
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2014, 1002, 'Quel joueur détient le plus de titres du Grand Chelem en tennis masculin ?', 'QCM', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3023, 2014, 'Rafael Nadal', false),
            (3024, 2014, 'Roger Federer', false),
            (3025, 2014, 'Novak Djokovic', true),
            (3026, 2014, 'Pete Sampras', false)");

        // Q6 : True/False
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2015, 1002, 'Le marathon olympique fait exactement 42,195 kilomètres.', 'True/False', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3027, 2015, 'True', true),
            (3028, 2015, 'False', false)");

        // Q7 : Open
        $this->addSql("INSERT INTO question (id, quiz_id, texte, type, duration) VALUES 
            (2016, 1002, 'Combien de joueurs composent une équipe de rugby sur le terrain ?', 'Open', 120)");
        $this->addSql("INSERT INTO answer (id, question_id, texte, is_correct) VALUES 
            (3029, 2016, '15', true)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM answer WHERE question_id BETWEEN 2010 AND 2016');
        $this->addSql('DELETE FROM question WHERE quiz_id = 1002');
        $this->addSql('DELETE FROM quiz WHERE id = 1002');
    }
}
