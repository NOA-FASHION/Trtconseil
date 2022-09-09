<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909214525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD intitule_poste VARCHAR(70) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD lieu_travail VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD horaire_post VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD salaire DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD desciption_poste VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE annonce DROP intitule_poste');
        $this->addSql('ALTER TABLE annonce DROP lieu_travail');
        $this->addSql('ALTER TABLE annonce DROP horaire_post');
        $this->addSql('ALTER TABLE annonce DROP salaire');
        $this->addSql('ALTER TABLE annonce DROP desciption_poste');
    }
}
