<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220914205845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recruteur ADD user_recrutueur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recruteur ADD CONSTRAINT FK_2BD3678CAD6AFF86 FOREIGN KEY (user_recrutueur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2BD3678CAD6AFF86 ON recruteur (user_recrutueur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE recruteur DROP CONSTRAINT FK_2BD3678CAD6AFF86');
        $this->addSql('DROP INDEX UNIQ_2BD3678CAD6AFF86');
        $this->addSql('ALTER TABLE recruteur DROP user_recrutueur_id');
    }
}
