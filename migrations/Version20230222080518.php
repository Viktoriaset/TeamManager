<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222080518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE group_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE organization_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE event ADD date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE event DROP date');
        $this->addSql('ALTER TABLE event DROP "time"');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA74F4A11B1 ON event (date_time)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE organization_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA74F4A11B1');
        $this->addSql('ALTER TABLE event ADD date DATE NOT NULL');
        $this->addSql('ALTER TABLE event ADD "time" TIME(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE event DROP date_time');
    }
}
