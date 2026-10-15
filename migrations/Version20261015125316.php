<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261015125316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, titre, date, informations, nombre_de_places, image, statut FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date DATETIME NOT NULL, informations CLOB NOT NULL, nombre_de_places INTEGER NOT NULL, image VARCHAR(255) DEFAULT NULL, validated BOOLEAN NOT NULL, category VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO event (id, titre, date, informations, nombre_de_places, image, validated) SELECT id, titre, date, informations, nombre_de_places, image, statut FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, titre, date, informations, nombre_de_places, image, validated FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date DATETIME NOT NULL, informations CLOB DEFAULT NULL, nombre_de_places INTEGER NOT NULL, image CLOB DEFAULT NULL, statut BOOLEAN NOT NULL, catégories CLOB NOT NULL)');
        $this->addSql('INSERT INTO event (id, titre, date, informations, nombre_de_places, image, statut) SELECT id, titre, date, informations, nombre_de_places, image, validated FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }
}
