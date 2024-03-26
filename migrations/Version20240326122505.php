<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326122505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE height (id INT AUTO_INCREMENT NOT NULL, height_id INT NOT NULL, UNIQUE INDEX UNIQ_F54DE50F4679B87C (height_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE height ADD CONSTRAINT FK_F54DE50F4679B87C FOREIGN KEY (height_id) REFERENCES health_container (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE height DROP FOREIGN KEY FK_F54DE50F4679B87C');
        $this->addSql('DROP TABLE height');
    }
}
