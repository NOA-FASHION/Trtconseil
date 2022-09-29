<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928172736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce_candidat (annonce_id INT NOT NULL, candidat_id INT NOT NULL, PRIMARY KEY(annonce_id, candidat_id))');
        $this->addSql('CREATE INDEX IDX_27FDBAB38805AB2F ON annonce_candidat (annonce_id)');
        $this->addSql('CREATE INDEX IDX_27FDBAB38D0EB82 ON annonce_candidat (candidat_id)');
        $this->addSql('ALTER TABLE annonce_candidat ADD CONSTRAINT FK_27FDBAB38805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce_candidat ADD CONSTRAINT FK_27FDBAB38D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE annonce_candidat DROP CONSTRAINT FK_27FDBAB38805AB2F');
        $this->addSql('ALTER TABLE annonce_candidat DROP CONSTRAINT FK_27FDBAB38D0EB82');
        $this->addSql('DROP TABLE annonce_candidat');
    }
}
