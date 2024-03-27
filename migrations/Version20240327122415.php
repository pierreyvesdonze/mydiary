<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327122415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blood_type (id INT AUTO_INCREMENT NOT NULL, health_container_id INT NOT NULL, value VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_7C46DDF3B9ED8DA (health_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blood_type ADD CONSTRAINT FK_7C46DDF3B9ED8DA FOREIGN KEY (health_container_id) REFERENCES health_container (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blood_type DROP FOREIGN KEY FK_7C46DDF3B9ED8DA');
        $this->addSql('DROP TABLE blood_type');
    }
}
