<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220085051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE training (date_training TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, team_id INT NOT NULL, trainee_id INT NOT NULL, visited BOOLEAN NOT NULL, explanatory TEXT DEFAULT NULL, PRIMARY KEY(date_training, team_id, trainee_id))');
        $this->addSql('CREATE INDEX IDX_D5128A8F296CD8AE ON training (team_id)');
        $this->addSql('CREATE INDEX IDX_D5128A8F36C682D0 ON training (trainee_id)');
        $this->addSql('COMMENT ON COLUMN training.date_training IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F36C682D0 FOREIGN KEY (trainee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE training DROP CONSTRAINT FK_D5128A8F296CD8AE');
        $this->addSql('ALTER TABLE training DROP CONSTRAINT FK_D5128A8F36C682D0');
        $this->addSql('DROP TABLE training');
    }
}
