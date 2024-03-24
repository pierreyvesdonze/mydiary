<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323181646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE friendship (id INT AUTO_INCREMENT NOT NULL, user1_id INT NOT NULL, user2_id INT NOT NULL, INDEX IDX_7234A45F56AE248B (user1_id), INDEX IDX_7234A45F441B8B65 (user2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friendship_request (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, INDEX IDX_6CC48EE1F624B39D (sender_id), INDEX IDX_6CC48EE1E92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F56AE248B FOREIGN KEY (user1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE friendship ADD CONSTRAINT FK_7234A45F441B8B65 FOREIGN KEY (user2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE friendship_request ADD CONSTRAINT FK_6CC48EE1F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE friendship_request ADD CONSTRAINT FK_6CC48EE1E92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45F56AE248B');
        $this->addSql('ALTER TABLE friendship DROP FOREIGN KEY FK_7234A45F441B8B65');
        $this->addSql('ALTER TABLE friendship_request DROP FOREIGN KEY FK_6CC48EE1F624B39D');
        $this->addSql('ALTER TABLE friendship_request DROP FOREIGN KEY FK_6CC48EE1E92F8F78');
        $this->addSql('DROP TABLE friendship');
        $this->addSql('DROP TABLE friendship_request');
    }
}
