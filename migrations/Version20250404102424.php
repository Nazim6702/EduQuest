<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404102424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_Question_Answer');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answer RENAME INDEX fk_question_answer TO IDX_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_Quiz_Question');
        $this->addSql('ALTER TABLE question CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE question RENAME INDEX fk_quiz_question TO IDX_B6F7494E853CD175');
        $this->addSql('ALTER TABLE quiz CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_Question_Answer FOREIGN KEY (question_id) REFERENCES question (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answer RENAME INDEX idx_dadd4a251e27f6bf TO FK_Question_Answer');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E853CD175');
        $this->addSql('ALTER TABLE question CHANGE type type VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_Quiz_Question FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question RENAME INDEX idx_b6f7494e853cd175 TO FK_Quiz_Question');
        $this->addSql('ALTER TABLE quiz CHANGE description description TEXT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
