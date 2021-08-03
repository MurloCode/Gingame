<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803065943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historic (id INT AUTO_INCREMENT NOT NULL, quizz_id INT DEFAULT NULL, user_id INT DEFAULT NULL, score SMALLINT NOT NULL, out_of SMALLINT NOT NULL, played_at DATETIME NOT NULL, INDEX IDX_AD52EF56BA934BCD (quizz_id), INDEX IDX_AD52EF56A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, text VARCHAR(500) NOT NULL, is_valid TINYINT(1) NOT NULL, type VARCHAR(255) DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, INDEX IDX_C7CDC3531E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, right_text VARCHAR(255) DEFAULT NULL, right_elem VARCHAR(255) DEFAULT NULL, wrong_text VARCHAR(255) DEFAULT NULL, wrong_elem VARCHAR(255) DEFAULT NULL, INDEX IDX_B6F7494EB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_theme (question_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_A79EF60C1E27F6BF (question_id), INDEX IDX_A79EF60C59027487 (theme_id), PRIMARY KEY(question_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizz (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, INDEX IDX_7C77973DB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizz_question (quizz_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_3723B55CBA934BCD (quizz_id), INDEX IDX_3723B55C1E27F6BF (question_id), PRIMARY KEY(quizz_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizz_theme (quizz_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_6D8CEDF6BA934BCD (quizz_id), INDEX IDX_6D8CEDF659027487 (theme_id), PRIMARY KEY(quizz_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_theme (theme_source INT NOT NULL, theme_target INT NOT NULL, INDEX IDX_CF576CED8FB24B0F (theme_source), INDEX IDX_CF576CED96571B80 (theme_target), PRIMARY KEY(theme_source, theme_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, imageurl VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF56BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF56A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC3531E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quizz_question ADD CONSTRAINT FK_3723B55CBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizz_question ADD CONSTRAINT FK_3723B55C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizz_theme ADD CONSTRAINT FK_6D8CEDF6BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizz_theme ADD CONSTRAINT FK_6D8CEDF659027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_theme ADD CONSTRAINT FK_CF576CED8FB24B0F FOREIGN KEY (theme_source) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_theme ADD CONSTRAINT FK_CF576CED96571B80 FOREIGN KEY (theme_target) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC3531E27F6BF');
        $this->addSql('ALTER TABLE question_theme DROP FOREIGN KEY FK_A79EF60C1E27F6BF');
        $this->addSql('ALTER TABLE quizz_question DROP FOREIGN KEY FK_3723B55C1E27F6BF');
        $this->addSql('ALTER TABLE historic DROP FOREIGN KEY FK_AD52EF56BA934BCD');
        $this->addSql('ALTER TABLE quizz_question DROP FOREIGN KEY FK_3723B55CBA934BCD');
        $this->addSql('ALTER TABLE quizz_theme DROP FOREIGN KEY FK_6D8CEDF6BA934BCD');
        $this->addSql('ALTER TABLE question_theme DROP FOREIGN KEY FK_A79EF60C59027487');
        $this->addSql('ALTER TABLE quizz_theme DROP FOREIGN KEY FK_6D8CEDF659027487');
        $this->addSql('ALTER TABLE theme_theme DROP FOREIGN KEY FK_CF576CED8FB24B0F');
        $this->addSql('ALTER TABLE theme_theme DROP FOREIGN KEY FK_CF576CED96571B80');
        $this->addSql('ALTER TABLE historic DROP FOREIGN KEY FK_AD52EF56A76ED395');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EB03A8386');
        $this->addSql('ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973DB03A8386');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
        $this->addSql('DROP TABLE historic');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_theme');
        $this->addSql('DROP TABLE quizz');
        $this->addSql('DROP TABLE quizz_question');
        $this->addSql('DROP TABLE quizz_theme');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_user');
    }
}
