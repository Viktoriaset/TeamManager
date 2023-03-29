<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222094021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_3bae0aa74f4a11b1');
        $this->addSql('ALTER TABLE event RENAME COLUMN date_time TO training_date');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA7A5047039 ON event (training_date)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA7A5047039');
        $this->addSql('ALTER TABLE event RENAME COLUMN training_date TO date_time');
        $this->addSql('CREATE UNIQUE INDEX uniq_3bae0aa74f4a11b1 ON event (date_time)');
    }
}
