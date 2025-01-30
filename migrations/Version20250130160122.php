<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130160122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE goal ADD category_id INT NOT NULL, DROP category');
        $this->addSql('ALTER TABLE goal ADD CONSTRAINT FK_FCDCEB2E12469DE2 FOREIGN KEY (category_id) REFERENCES goal_category (id)');
        $this->addSql('CREATE INDEX IDX_FCDCEB2E12469DE2 ON goal (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE goal DROP FOREIGN KEY FK_FCDCEB2E12469DE2');
        $this->addSql('DROP INDEX IDX_FCDCEB2E12469DE2 ON goal');
        $this->addSql('ALTER TABLE goal ADD category VARCHAR(255) NOT NULL, DROP category_id');
    }
}
