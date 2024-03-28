<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328152258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE health_condition (id INT AUTO_INCREMENT NOT NULL, health_container_id INT NOT NULL, title VARCHAR(40) NOT NULL, INDEX IDX_8C5023D1B9ED8DA (health_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE health_condition ADD CONSTRAINT FK_8C5023D1B9ED8DA FOREIGN KEY (health_container_id) REFERENCES health_container (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE health_condition DROP FOREIGN KEY FK_8C5023D1B9ED8DA');
        $this->addSql('DROP TABLE health_condition');
    }
}
