<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221234735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP CONSTRAINT fk_70e4fa789d86650f');
        $this->addSql('DROP INDEX idx_70e4fa789d86650f');
        $this->addSql('ALTER TABLE member RENAME COLUMN user_id_id TO user_data_id');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA786FF8BF36 FOREIGN KEY (user_data_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_70E4FA786FF8BF36 ON member (user_data_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE member DROP CONSTRAINT FK_70E4FA786FF8BF36');
        $this->addSql('DROP INDEX IDX_70E4FA786FF8BF36');
        $this->addSql('ALTER TABLE member RENAME COLUMN user_data_id TO user_id_id');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT fk_70e4fa789d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_70e4fa789d86650f ON member (user_id_id)');
    }
}
