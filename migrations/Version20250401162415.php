<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401162415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD question_id INT NOT NULL, ADD is_correct TINYINT(1) NOT NULL, CHANGE texte texte VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('ALTER TABLE participation ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24FA76ED395 ON participation (user_id)');
        $this->addSql('ALTER TABLE question ADD quiz_id INT NOT NULL, CHANGE titre texte VARCHAR(255) NOT NULL, CHANGE durée duration INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E853CD175 ON question (quiz_id)');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA9261220EA6');
        $this->addSql('DROP INDEX IDX_A412FA9261220EA6 ON quiz');
        $this->addSql('ALTER TABLE quiz ADD category VARCHAR(255) NOT NULL, DROP duree, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE titre title VARCHAR(255) NOT NULL, CHANGE creator_id duration INT NOT NULL, CHANGE date_creation created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD user_type VARCHAR(255) NOT NULL, ADD admin_level INT DEFAULT NULL, ADD grade_level VARCHAR(50) DEFAULT NULL, ADD subject VARCHAR(100) DEFAULT NULL, DROP badges, CHANGE email email VARCHAR(255) NOT NULL, CHANGE type name VARCHAR(255) NOT NULL, CHANGE permissions pseudo VARCHAR(255) DEFAULT NULL, CHANGE registration_date created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user_answer ADD question_id INT NOT NULL, DROP texte, CHANGE est_correcte is_correct TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F51181E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_BF8F51181E27F6BF ON user_answer (question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_answer DROP FOREIGN KEY FK_BF8F51181E27F6BF');
        $this->addSql('DROP INDEX IDX_BF8F51181E27F6BF ON user_answer');
        $this->addSql('ALTER TABLE user_answer ADD texte VARCHAR(255) NOT NULL, DROP question_id, CHANGE is_correct est_correcte TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD type VARCHAR(255) NOT NULL, ADD badges LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP name, DROP user_type, DROP admin_level, DROP grade_level, DROP subject, CHANGE email email VARCHAR(180) NOT NULL, CHANGE pseudo permissions VARCHAR(255) DEFAULT NULL, CHANGE created_at registration_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD titre VARCHAR(255) NOT NULL, ADD duree INT DEFAULT NULL, DROP title, DROP category, CHANGE description description VARCHAR(255) NOT NULL, CHANGE duration creator_id INT NOT NULL, CHANGE created_at date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA9261220EA6 FOREIGN KEY (creator_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A412FA9261220EA6 ON quiz (creator_id)');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('DROP INDEX IDX_DADD4A251E27F6BF ON answer');
        $this->addSql('ALTER TABLE answer DROP question_id, DROP is_correct, CHANGE texte texte VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E853CD175');
        $this->addSql('DROP INDEX IDX_B6F7494E853CD175 ON question');
        $this->addSql('ALTER TABLE question DROP quiz_id, CHANGE texte titre VARCHAR(255) NOT NULL, CHANGE duration durée INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('DROP INDEX IDX_AB55E24FA76ED395 ON participation');
        $this->addSql('ALTER TABLE participation DROP user_id');
    }
}
