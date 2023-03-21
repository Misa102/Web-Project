<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320221636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE i23_images (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_produit INTEGER NOT NULL, url VARCHAR(255) NOT NULL, url_mini VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) NOT NULL, CONSTRAINT FK_41BD7D91F7384557 FOREIGN KEY (id_produit) REFERENCES i23_produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_41BD7D91F7384557 ON i23_images (id_produit)');
        $this->addSql('CREATE TABLE pays (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_produits AS SELECT id, denomination, code, date_creation, actif, descriptif FROM i23_produits');
        $this->addSql('DROP TABLE i23_produits');
        $this->addSql('CREATE TABLE i23_produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_manuel INTEGER DEFAULT NULL, denomination VARCHAR(255) NOT NULL, code VARCHAR(30) NOT NULL --code barre
        , date_creation DATETIME NOT NULL, actif BOOLEAN DEFAULT 0 NOT NULL, descriptif CLOB NOT NULL, CONSTRAINT FK_4B08D5525280CE2D FOREIGN KEY (id_manuel) REFERENCES i23_manuels (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO i23_produits (id, denomination, code, date_creation, actif, descriptif) SELECT id, denomination, code, date_creation, actif, descriptif FROM __temp__i23_produits');
        $this->addSql('DROP TABLE __temp__i23_produits');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B08D5525280CE2D ON i23_produits (id_manuel)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE i23_images');
        $this->addSql('DROP TABLE pays');
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_produits AS SELECT id, denomination, code, date_creation, actif, descriptif FROM i23_produits');
        $this->addSql('DROP TABLE i23_produits');
        $this->addSql('CREATE TABLE i23_produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, denomination VARCHAR(255) NOT NULL, code VARCHAR(30) NOT NULL --code barre
        , date_creation DATETIME NOT NULL, actif BOOLEAN DEFAULT 0 NOT NULL, descriptif CLOB NOT NULL)');
        $this->addSql('INSERT INTO i23_produits (id, denomination, code, date_creation, actif, descriptif) SELECT id, denomination, code, date_creation, actif, descriptif FROM __temp__i23_produits');
        $this->addSql('DROP TABLE __temp__i23_produits');
    }
}
