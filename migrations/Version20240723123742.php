<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723123742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add the created_at column with a default value equal to open_time
        $this->addSql('ALTER TABLE operation ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('COMMENT ON COLUMN operation.created_at IS \'(DC2Type:datetime_immutable)\'');

        // Update existing rows to have created_at value equal to open_time
        $this->addSql('UPDATE operation SET created_at = open_time');

        // Alter the column to set it as NOT NULL
        $this->addSql('ALTER TABLE operation ALTER COLUMN created_at SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP created_at');
    }
}
