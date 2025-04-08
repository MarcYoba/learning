<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407124231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription ADD module_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6AFC2B591 ON inscription (module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6AFC2B591');
        $this->addSql('DROP INDEX IDX_5E90F6D6AFC2B591 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP module_id');
    }
}
