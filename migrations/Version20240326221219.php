<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326221219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE height DROP FOREIGN KEY FK_F54DE50F4679B87C');
        $this->addSql('DROP INDEX UNIQ_F54DE50F4679B87C ON height');
        $this->addSql('ALTER TABLE height ADD value SMALLINT NOT NULL, CHANGE height_id health_container_id INT NOT NULL');
        $this->addSql('ALTER TABLE height ADD CONSTRAINT FK_F54DE50FB9ED8DA FOREIGN KEY (health_container_id) REFERENCES health_container (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F54DE50FB9ED8DA ON height (health_container_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE height DROP FOREIGN KEY FK_F54DE50FB9ED8DA');
        $this->addSql('DROP INDEX UNIQ_F54DE50FB9ED8DA ON height');
        $this->addSql('ALTER TABLE height DROP value, CHANGE health_container_id height_id INT NOT NULL');
        $this->addSql('ALTER TABLE height ADD CONSTRAINT FK_F54DE50F4679B87C FOREIGN KEY (height_id) REFERENCES health_container (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F54DE50F4679B87C ON height (height_id)');
    }
}
