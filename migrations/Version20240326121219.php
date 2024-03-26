<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326121219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE care (id INT AUTO_INCREMENT NOT NULL, health_container_id INT NOT NULL, title VARCHAR(64) NOT NULL, date DATETIME NOT NULL, INDEX IDX_6113A845B9ED8DA (health_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health_container (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, visibility TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F6244789A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vaccine (id INT AUTO_INCREMENT NOT NULL, health_container_id INT NOT NULL, title VARCHAR(255) NOT NULL, vaccine_date DATETIME NOT NULL, deadline DATETIME NOT NULL, INDEX IDX_A7DD90B1B9ED8DA (health_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weight (id INT AUTO_INCREMENT NOT NULL, health_container_id INT NOT NULL, weight NUMERIC(5, 2) NOT NULL, date DATETIME NOT NULL, INDEX IDX_7CD5541B9ED8DA (health_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE care ADD CONSTRAINT FK_6113A845B9ED8DA FOREIGN KEY (health_container_id) REFERENCES health_container (id)');
        $this->addSql('ALTER TABLE health_container ADD CONSTRAINT FK_F6244789A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vaccine ADD CONSTRAINT FK_A7DD90B1B9ED8DA FOREIGN KEY (health_container_id) REFERENCES health_container (id)');
        $this->addSql('ALTER TABLE weight ADD CONSTRAINT FK_7CD5541B9ED8DA FOREIGN KEY (health_container_id) REFERENCES health_container (id)');
        $this->addSql('INSERT INTO health_container (user_id, visibility) SELECT id, 0 FROM user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE care DROP FOREIGN KEY FK_6113A845B9ED8DA');
        $this->addSql('ALTER TABLE health_container DROP FOREIGN KEY FK_F6244789A76ED395');
        $this->addSql('ALTER TABLE vaccine DROP FOREIGN KEY FK_A7DD90B1B9ED8DA');
        $this->addSql('ALTER TABLE weight DROP FOREIGN KEY FK_7CD5541B9ED8DA');
        $this->addSql('DROP TABLE care');
        $this->addSql('DROP TABLE health_container');
        $this->addSql('DROP TABLE vaccine');
        $this->addSql('DROP TABLE weight');
    }
}
