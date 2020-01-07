<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107220952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE persona ADD prestamo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69B135A846E FOREIGN KEY (prestamo_id) REFERENCES prestamo (id)');
        $this->addSql('CREATE INDEX IDX_51E5B69B135A846E ON persona (prestamo_id)');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2F5F88DB9');
        $this->addSql('DROP INDEX UNIQ_F4D874F2F5F88DB9 ON prestamo');
        $this->addSql('ALTER TABLE prestamo DROP persona_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE persona DROP FOREIGN KEY FK_51E5B69B135A846E');
        $this->addSql('DROP INDEX IDX_51E5B69B135A846E ON persona');
        $this->addSql('ALTER TABLE persona DROP prestamo_id');
        $this->addSql('ALTER TABLE prestamo ADD persona_id INT NOT NULL');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F4D874F2F5F88DB9 ON prestamo (persona_id)');
    }
}
