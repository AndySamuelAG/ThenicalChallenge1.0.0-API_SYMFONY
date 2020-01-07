<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200102213608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, biblioteca_id INT NOT NULL, prestamo_id_id INT DEFAULT NULL, tipo VARCHAR(20) NOT NULL, codigo VARCHAR(10) NOT NULL, autor VARCHAR(100) NOT NULL, titulo VARCHAR(255) NOT NULL, anio INT NOT NULL, status VARCHAR(20) NOT NULL, precio DOUBLE PRECISION NOT NULL, editorial VARCHAR(100) NOT NULL, INDEX IDX_7CBE75956A5EDAE9 (biblioteca_id), INDEX IDX_7CBE7595F059C6AC (prestamo_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE biblioteca (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, biblioteca_id INT NOT NULL, tipo VARCHAR(30) NOT NULL, nombre VARCHAR(30) NOT NULL, correo VARCHAR(255) NOT NULL, telefono INT NOT NULL, libros INT DEFAULT NULL, adeudo DOUBLE PRECISION DEFAULT NULL, num_persona INT NOT NULL, INDEX IDX_51E5B69B6A5EDAE9 (biblioteca_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, persona_id_id INT NOT NULL, biblioteca_id INT NOT NULL, prestamo_id INT NOT NULL, entregado TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_F4D874F291859C72 (persona_id_id), INDEX IDX_F4D874F26A5EDAE9 (biblioteca_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE75956A5EDAE9 FOREIGN KEY (biblioteca_id) REFERENCES biblioteca (id)');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595F059C6AC FOREIGN KEY (prestamo_id_id) REFERENCES prestamo (id)');
        $this->addSql('ALTER TABLE persona ADD CONSTRAINT FK_51E5B69B6A5EDAE9 FOREIGN KEY (biblioteca_id) REFERENCES biblioteca (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F291859C72 FOREIGN KEY (persona_id_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F26A5EDAE9 FOREIGN KEY (biblioteca_id) REFERENCES biblioteca (id)');
        $this->addSql('DROP TABLE Bibliotecas');
        $this->addSql('DROP TABLE Materiales');
        $this->addSql('DROP TABLE Personas');
        $this->addSql('DROP TABLE Prestamos');
        $this->addSql('DROP TABLE migrations');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE75956A5EDAE9');
        $this->addSql('ALTER TABLE persona DROP FOREIGN KEY FK_51E5B69B6A5EDAE9');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F26A5EDAE9');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F291859C72');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE7595F059C6AC');
        $this->addSql('CREATE TABLE Bibliotecas (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, created_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, updated_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Materiales (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, tipo VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, codigo VARCHAR(20) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, autor VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, titulo VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, anio INT NOT NULL, status VARCHAR(15) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, precio DOUBLE PRECISION NOT NULL, editorial VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, biblioteca INT NOT NULL, created_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, updated_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Personas (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, tipo VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, nombre VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, apellido VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, correo VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, telefono INT NOT NULL, libros INT DEFAULT 0 NOT NULL, adeudo DOUBLE PRECISION DEFAULT \'0.00\' NOT NULL, numPersona INT NOT NULL, prestamoId INT NOT NULL, biblioteca INT NOT NULL, created_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, updated_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Prestamos (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, personaId INT NOT NULL, prestamoId INT NOT NULL, materialId INT NOT NULL, valor DOUBLE PRECISION NOT NULL, fechaSalida DATETIME DEFAULT \'current_timestamp()\' NOT NULL, fechaRegreso DATETIME NOT NULL, entregado TINYINT(1) DEFAULT \'0\' NOT NULL, biblioteca INT NOT NULL, created_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, updated_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE migrations (migration VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, batch INT NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE biblioteca');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE prestamo');
    }
}
