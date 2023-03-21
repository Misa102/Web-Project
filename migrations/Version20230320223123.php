<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320223123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE i23_produits_pays (id_produit INTEGER NOT NULL, id_pays INTEGER NOT NULL, PRIMARY KEY(id_produit, id_pays), CONSTRAINT FK_277D5EC3F7384557 FOREIGN KEY (id_produit) REFERENCES i23_produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_277D5EC3BFBF20AC FOREIGN KEY (id_pays) REFERENCES i23_pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_277D5EC3F7384557 ON i23_produits_pays (id_produit)');
        $this->addSql('CREATE INDEX IDX_277D5EC3BFBF20AC ON i23_produits_pays (id_pays)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE i23_produits_pays');
    }
}
