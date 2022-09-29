<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928190835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat_annonce (candidat_id INT NOT NULL, annonce_id INT NOT NULL, PRIMARY KEY(candidat_id, annonce_id))');
        $this->addSql('CREATE INDEX IDX_AF58650F8D0EB82 ON candidat_annonce (candidat_id)');
        $this->addSql('CREATE INDEX IDX_AF58650F8805AB2F ON candidat_annonce (annonce_id)');
        $this->addSql('ALTER TABLE candidat_annonce ADD CONSTRAINT FK_AF58650F8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE candidat_annonce ADD CONSTRAINT FK_AF58650F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce_candidat DROP CONSTRAINT fk_27fdbab38805ab2f');
        $this->addSql('ALTER TABLE annonce_candidat DROP CONSTRAINT fk_27fdbab38d0eb82');
        $this->addSql('DROP TABLE annonce_candidat');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE annonce_candidat (annonce_id INT NOT NULL, candidat_id INT NOT NULL, PRIMARY KEY(annonce_id, candidat_id))');
        $this->addSql('CREATE INDEX idx_27fdbab38d0eb82 ON annonce_candidat (candidat_id)');
        $this->addSql('CREATE INDEX idx_27fdbab38805ab2f ON annonce_candidat (annonce_id)');
        $this->addSql('ALTER TABLE annonce_candidat ADD CONSTRAINT fk_27fdbab38805ab2f FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE annonce_candidat ADD CONSTRAINT fk_27fdbab38d0eb82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE candidat_annonce DROP CONSTRAINT FK_AF58650F8D0EB82');
        $this->addSql('ALTER TABLE candidat_annonce DROP CONSTRAINT FK_AF58650F8805AB2F');
        $this->addSql('DROP TABLE candidat_annonce');
    }
}
