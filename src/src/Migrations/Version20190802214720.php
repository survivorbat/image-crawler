<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802214720 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription() : string
    {
        return 'Initial migration';
    }

    /**
     * @param Schema $schema
     */
    public function preUp(Schema $schema): void
    {
        $this->addSql('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE scrape_origin (id VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT \'\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE saved_image (id VARCHAR(255) NOT NULL, scrape_origin_id VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) DEFAULT \'\' NOT NULL, pathname VARCHAR(255) DEFAULT \'\' NOT NULL, base_name VARCHAR(255) DEFAULT \'\' NOT NULL, public_path VARCHAR(255) DEFAULT \'\' NOT NULL, path VARCHAR(255) DEFAULT \'\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A8EEDF466C4F163E ON saved_image (scrape_origin_id)');
        $this->addSql('ALTER TABLE saved_image ADD CONSTRAINT FK_A8EEDF466C4F163E FOREIGN KEY (scrape_origin_id) REFERENCES scrape_origin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE saved_image DROP CONSTRAINT FK_A8EEDF466C4F163E');
        $this->addSql('DROP TABLE scrape_origin');
        $this->addSql('DROP TABLE saved_image');
    }
}
