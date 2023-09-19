<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917175134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (uuid VARCHAR(36) NOT NULL, name VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, profile_picture_link VARCHAR(255) DEFAULT NULL, biography TEXT DEFAULT NULL, registration_date TIMESTAMP(0) WITH TIME ZONE NOT NULL, last_login_date TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, verified_date TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX users_email_key ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX users_name_key ON users (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}
