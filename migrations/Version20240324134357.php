<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324134357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dates_container (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, visibility TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_CA8B51B0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dates_container ADD CONSTRAINT FK_CA8B51B0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE date CHANGE dates_id dates_container_id INT NOT NULL');
        $this->addSql('ALTER TABLE date ADD CONSTRAINT FK_AA9E377A7AD50D57 FOREIGN KEY (dates_container_id) REFERENCES dates_container (id)');
        $this->addSql('CREATE INDEX IDX_AA9E377A7AD50D57 ON date (dates_container_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE date DROP FOREIGN KEY FK_AA9E377A7AD50D57');
        $this->addSql('ALTER TABLE dates_container DROP FOREIGN KEY FK_CA8B51B0A76ED395');
        $this->addSql('DROP TABLE dates_container');
        $this->addSql('DROP INDEX IDX_AA9E377A7AD50D57 ON date');
        $this->addSql('ALTER TABLE date CHANGE dates_container_id dates_id INT NOT NULL');
    }
}
