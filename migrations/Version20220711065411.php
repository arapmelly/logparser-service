<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711065411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE log_detail (id INT AUTO_INCREMENT NOT NULL, log_entry_id_id INT DEFAULT NULL, service VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, time TIME DEFAULT NULL, request_type VARCHAR(255) DEFAULT NULL, http_header VARCHAR(255) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, status_code INT DEFAULT NULL, INDEX IDX_3BFC2C31A7E78159 (log_entry_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE log_detail ADD CONSTRAINT FK_3BFC2C31A7E78159 FOREIGN KEY (log_entry_id_id) REFERENCES log_entry (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE log_detail');
    }
}
