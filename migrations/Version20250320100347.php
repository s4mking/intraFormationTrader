<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Modified for MariaDB compatibility.
 */
final class Version20250320100347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create file table for MariaDB';
    }

    public function up(Schema $schema): void
    {
        // Créer la table file avec AUTO_INCREMENT pour l'ID et DATETIME pour updated_at
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        // Ajouter un index sur user_id
        $this->addSql('CREATE INDEX IDX_8C9F3610A76ED395 ON file (user_id)');
        // Ajouter la contrainte de clé étrangère
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // Supprimer la contrainte de clé étrangère
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        // Supprimer la table file
        $this->addSql('DROP TABLE file');
    }
}
