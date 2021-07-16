<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715130346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, text VARCHAR(500) NOT NULL, is_valid TINYINT(1) NOT NULL, type VARCHAR(255) DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, INDEX IDX_C7CDC3531E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, right_text VARCHAR(255) DEFAULT NULL, right_elem VARCHAR(255) DEFAULT NULL, wrong_text VARCHAR(255) DEFAULT NULL, wrong_elem VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizz (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_theme (theme_source INT NOT NULL, theme_target INT NOT NULL, INDEX IDX_CF576CED8FB24B0F (theme_source), INDEX IDX_CF576CED96571B80 (theme_target), PRIMARY KEY(theme_source, theme_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC3531E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE theme_theme ADD CONSTRAINT FK_CF576CED8FB24B0F FOREIGN KEY (theme_source) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_theme ADD CONSTRAINT FK_CF576CED96571B80 FOREIGN KEY (theme_target) REFERENCES theme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC3531E27F6BF');
        $this->addSql('ALTER TABLE theme_theme DROP FOREIGN KEY FK_CF576CED8FB24B0F');
        $this->addSql('ALTER TABLE theme_theme DROP FOREIGN KEY FK_CF576CED96571B80');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quizz');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_theme');
        $this->addSql('DROP TABLE user');
    }
}
