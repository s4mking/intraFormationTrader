<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719124907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE operation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE operation (id INT NOT NULL, transmitter_id INT NOT NULL, symbol VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, type VARCHAR(255) NOT NULL, lots INT DEFAULT NULL, open_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, open_price DOUBLE PRECISION DEFAULT NULL, close_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, close_price DOUBLE PRECISION DEFAULT NULL, profit INT DEFAULT NULL, net_profit INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1981A66DB703C510 ON operation (transmitter_id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DB703C510 FOREIGN KEY (transmitter_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE operation_id_seq CASCADE');
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT FK_1981A66DB703C510');
        $this->addSql('DROP TABLE operation');
    }
}
