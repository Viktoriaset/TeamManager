<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221080331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE team_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, member_id INT NOT NULL, date DATE NOT NULL, time TIME(0) WITHOUT TIME ZONE NOT NULL, visited BOOLEAN NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA77597D3FE ON event (member_id)');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, group_id INT NOT NULL, user_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_70E4FA78FE54D947 ON member (group_id)');
        $this->addSql('CREATE INDEX IDX_70E4FA789D86650F ON member (user_id_id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA77597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA789D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_user DROP CONSTRAINT fk_5c722232296cd8ae');
        $this->addSql('ALTER TABLE team_user DROP CONSTRAINT fk_5c722232a76ed395');
        $this->addSql('ALTER TABLE training DROP CONSTRAINT fk_d5128a8f296cd8ae');
        $this->addSql('ALTER TABLE training DROP CONSTRAINT fk_d5128a8f36c682d0');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_user');
        $this->addSql('DROP TABLE training');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE team (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, training_days JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE team_user (team_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(team_id, user_id))');
        $this->addSql('CREATE INDEX idx_5c722232a76ed395 ON team_user (user_id)');
        $this->addSql('CREATE INDEX idx_5c722232296cd8ae ON team_user (team_id)');
        $this->addSql('CREATE TABLE training (date_training TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, team_id INT NOT NULL, trainee_id INT NOT NULL, visited BOOLEAN NOT NULL, explanatory TEXT DEFAULT NULL, PRIMARY KEY(date_training, team_id, trainee_id))');
        $this->addSql('CREATE INDEX idx_d5128a8f36c682d0 ON training (trainee_id)');
        $this->addSql('CREATE INDEX idx_d5128a8f296cd8ae ON training (team_id)');
        $this->addSql('COMMENT ON COLUMN training.date_training IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE team_user ADD CONSTRAINT fk_5c722232296cd8ae FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_user ADD CONSTRAINT fk_5c722232a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT fk_d5128a8f296cd8ae FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT fk_d5128a8f36c682d0 FOREIGN KEY (trainee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA77597D3FE');
        $this->addSql('ALTER TABLE member DROP CONSTRAINT FK_70E4FA78FE54D947');
        $this->addSql('ALTER TABLE member DROP CONSTRAINT FK_70E4FA789D86650F');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE member');
    }
}
