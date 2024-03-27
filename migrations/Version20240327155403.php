<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327155403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vaccine ADD injection_date DATE DEFAULT NULL, ADD deadline_date DATE DEFAULT NULL, DROP vaccine_date, DROP deadline');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vaccine ADD vaccine_date DATETIME NOT NULL, ADD deadline DATETIME NOT NULL, DROP injection_date, DROP deadline_date');
    }
}
