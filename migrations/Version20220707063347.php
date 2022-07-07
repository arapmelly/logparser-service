<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707063347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log_entry ADD log_file VARCHAR(255) DEFAULT NULL, ADD log_entry VARCHAR(255) DEFAULT NULL, DROP service_type, DROP date, DROP time, DROP request_type, DROP endpoint, DROP http_header, DROP status_code');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log_entry ADD service_type VARCHAR(255) DEFAULT NULL, ADD date DATE DEFAULT NULL, ADD time TIME DEFAULT NULL, ADD request_type VARCHAR(255) DEFAULT NULL, ADD endpoint VARCHAR(255) DEFAULT NULL, ADD http_header VARCHAR(255) DEFAULT NULL, ADD status_code VARCHAR(255) DEFAULT NULL, DROP log_file, DROP log_entry');
    }
}
