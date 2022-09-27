<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926211024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE candidature_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE candidature (id INT NOT NULL, candidat_id INT DEFAULT NULL, annonce_id INT DEFAULT NULL, is_enable BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E33BD3B88D0EB82 ON candidature (candidat_id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B88805AB2F ON candidature (annonce_id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B88D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B88805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE candidature_id_seq CASCADE');
        $this->addSql('ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B88D0EB82');
        $this->addSql('ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B88805AB2F');
        $this->addSql('DROP TABLE candidature');
    }
}
