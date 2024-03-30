<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329152947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE routine (id INT AUTO_INCREMENT NOT NULL, routine_container_id INT NOT NULL, title VARCHAR(64) NOT NULL, INDEX IDX_4BF6D8D6B2E34A3A (routine_container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE routine_container (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, visibility TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8E66D67A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE routine_task (id INT AUTO_INCREMENT NOT NULL, routine_id INT NOT NULL, start_time TIME NOT NULL, description LONGTEXT NOT NULL, duration TIME NOT NULL, INDEX IDX_48CA291DF27A94C7 (routine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE routine ADD CONSTRAINT FK_4BF6D8D6B2E34A3A FOREIGN KEY (routine_container_id) REFERENCES routine_container (id)');
        $this->addSql('ALTER TABLE routine_container ADD CONSTRAINT FK_8E66D67A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE routine_task ADD CONSTRAINT FK_48CA291DF27A94C7 FOREIGN KEY (routine_id) REFERENCES routine (id)');

       $this->addSql('INSERT INTO routine_container (user_id, visibility) SELECT id, 0 FROM user WHERE id NOT IN (SELECT user_id FROM routine_container)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE routine DROP FOREIGN KEY FK_4BF6D8D6B2E34A3A');
        $this->addSql('ALTER TABLE routine_container DROP FOREIGN KEY FK_8E66D67A76ED395');
        $this->addSql('ALTER TABLE routine_task DROP FOREIGN KEY FK_48CA291DF27A94C7');
        $this->addSql('DROP TABLE routine');
        $this->addSql('DROP TABLE routine_container');
        $this->addSql('DROP TABLE routine_task');
    }
}
