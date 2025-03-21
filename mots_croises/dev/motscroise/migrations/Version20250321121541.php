<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321121541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE case_m (id SERIAL NOT NULL, position_x INT NOT NULL, position_y INT NOT NULL, contenu VARCHAR(1) NOT NULL, affiche BOOLEAN DEFAULT false NOT NULL, case_partage BOOLEAN DEFAULT false NOT NULL, numero INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE case_mot (case_m_id INT NOT NULL, mot_id INT NOT NULL, PRIMARY KEY(case_m_id, mot_id))');
        $this->addSql('CREATE INDEX IDX_AC8F3DF8F0103653 ON case_mot (case_m_id)');
        $this->addSql('CREATE INDEX IDX_AC8F3DF863977652 ON case_mot (mot_id)');
        $this->addSql('CREATE TABLE funfact (id SERIAL NOT NULL, description TEXT NOT NULL, ID_Mot INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_460777766AC7C7A4 ON funfact (ID_Mot)');
        $this->addSql('CREATE TABLE joker (id SERIAL NOT NULL, utilise BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lettres (id SERIAL NOT NULL, contenu VARCHAR(1) NOT NULL, position_x INT NOT NULL, position_y INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mot (id SERIAL NOT NULL, mot VARCHAR(50) NOT NULL, definition TEXT NOT NULL, horizontal BOOLEAN NOT NULL, longueur INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE case_mot ADD CONSTRAINT FK_AC8F3DF8F0103653 FOREIGN KEY (case_m_id) REFERENCES case_m (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE case_mot ADD CONSTRAINT FK_AC8F3DF863977652 FOREIGN KEY (mot_id) REFERENCES mot (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE funfact ADD CONSTRAINT FK_460777766AC7C7A4 FOREIGN KEY (ID_Mot) REFERENCES mot (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE case_mot DROP CONSTRAINT FK_AC8F3DF8F0103653');
        $this->addSql('ALTER TABLE case_mot DROP CONSTRAINT FK_AC8F3DF863977652');
        $this->addSql('ALTER TABLE funfact DROP CONSTRAINT FK_460777766AC7C7A4');
        $this->addSql('DROP TABLE case_m');
        $this->addSql('DROP TABLE case_mot');
        $this->addSql('DROP TABLE funfact');
        $this->addSql('DROP TABLE joker');
        $this->addSql('DROP TABLE lettres');
        $this->addSql('DROP TABLE mot');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
