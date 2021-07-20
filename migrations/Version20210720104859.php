<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720104859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quizz_theme (quizz_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_6D8CEDF6BA934BCD (quizz_id), INDEX IDX_6D8CEDF659027487 (theme_id), PRIMARY KEY(quizz_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quizz_theme ADD CONSTRAINT FK_6D8CEDF6BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizz_theme ADD CONSTRAINT FK_6D8CEDF659027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE quizz_question');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quizz_question (quizz_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_3723B55C1E27F6BF (question_id), INDEX IDX_3723B55CBA934BCD (quizz_id), PRIMARY KEY(quizz_id, question_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quizz_question ADD CONSTRAINT FK_3723B55C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizz_question ADD CONSTRAINT FK_3723B55CBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE quizz_theme');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
    }
}
