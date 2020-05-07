<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507072217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE produit_enchere');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E80B6EFB');
        $this->addSql('DROP INDEX IDX_29A5EC27E80B6EFB ON produit');
        $this->addSql('ALTER TABLE produit ADD connect_id INT NOT NULL, DROP enchere_id, DROP created_at');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BF9EA4DC FOREIGN KEY (connect_id) REFERENCES enchere (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27BF9EA4DC ON produit (connect_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE produit_enchere (produit_id INT NOT NULL, enchere_id INT NOT NULL, INDEX IDX_FE2A0C76F347EFB (produit_id), INDEX IDX_FE2A0C76E80B6EFB (enchere_id), PRIMARY KEY(produit_id, enchere_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_enchere ADD CONSTRAINT FK_FE2A0C76E80B6EFB FOREIGN KEY (enchere_id) REFERENCES enchere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_enchere ADD CONSTRAINT FK_FE2A0C76F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BF9EA4DC');
        $this->addSql('DROP INDEX IDX_29A5EC27BF9EA4DC ON produit');
        $this->addSql('ALTER TABLE produit ADD enchere_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, DROP connect_id');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E80B6EFB FOREIGN KEY (enchere_id) REFERENCES enchere (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27E80B6EFB ON produit (enchere_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
