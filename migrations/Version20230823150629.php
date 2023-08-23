<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230823150629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD nom VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD prenom VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD telephone VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP nom');
        $this->addSql('ALTER TABLE "user" DROP prenom');
        $this->addSql('ALTER TABLE "user" DROP adresse');
        $this->addSql('ALTER TABLE "user" DROP telephone');
    }
}
