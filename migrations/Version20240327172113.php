<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327172113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medication (id INT AUTO_INCREMENT NOT NULL, health_container_id INT NOT NULL, name VARCHAR(34) NOT NULL, dosage VARCHAR(34) NOT NULL, INDEX IDX_5AEE5B70B9ED8DA (health_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medication ADD CONSTRAINT FK_5AEE5B70B9ED8DA FOREIGN KEY (health_container_id) REFERENCES health_container (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medication DROP FOREIGN KEY FK_5AEE5B70B9ED8DA');
        $this->addSql('DROP TABLE medication');
    }
}
