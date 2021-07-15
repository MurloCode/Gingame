<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715104127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE theme_theme (theme_source INT NOT NULL, theme_target INT NOT NULL, INDEX IDX_CF576CED8FB24B0F (theme_source), INDEX IDX_CF576CED96571B80 (theme_target), PRIMARY KEY(theme_source, theme_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE theme_theme ADD CONSTRAINT FK_CF576CED8FB24B0F FOREIGN KEY (theme_source) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_theme ADD CONSTRAINT FK_CF576CED96571B80 FOREIGN KEY (theme_target) REFERENCES theme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE theme_theme');
    }
}
