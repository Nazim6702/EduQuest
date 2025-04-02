<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402133305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE debate_message (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', likes INT NOT NULL, INDEX IDX_4CA444B5F675F31B (author_id), INDEX IDX_4CA444B5727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE debate_message ADD CONSTRAINT FK_4CA444B5F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE debate_message ADD CONSTRAINT FK_4CA444B5727ACA70 FOREIGN KEY (parent_id) REFERENCES debate_message (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE debate_message DROP FOREIGN KEY FK_4CA444B5F675F31B');
        $this->addSql('ALTER TABLE debate_message DROP FOREIGN KEY FK_4CA444B5727ACA70');
        $this->addSql('DROP TABLE debate_message');
        $this->addSql('DROP TABLE likes');
    }
}
