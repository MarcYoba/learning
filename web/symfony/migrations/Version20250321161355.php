<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321161355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', titre VARCHAR(255) NOT NULL, video VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_cours (module_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_F4C6FCF2AFC2B591 (module_id), INDEX IDX_F4C6FCF27ECF78B0 (cours_id), PRIMARY KEY(module_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module_cours ADD CONSTRAINT FK_F4C6FCF2AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_cours ADD CONSTRAINT FK_F4C6FCF27ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_cours DROP FOREIGN KEY FK_F4C6FCF2AFC2B591');
        $this->addSql('ALTER TABLE module_cours DROP FOREIGN KEY FK_F4C6FCF27ECF78B0');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_cours');
    }
}
