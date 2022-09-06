<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822132622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE virement (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, account_2_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, motif VARCHAR(255) DEFAULT NULL, date_execution DATE NOT NULL, INDEX IDX_2D4DCFA69B6B5FBA (account_id), INDEX IDX_2D4DCFA66EF574BE (account_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE virement ADD CONSTRAINT FK_2D4DCFA69B6B5FBA FOREIGN KEY (account_id) REFERENCES `account` (id)');
        $this->addSql('ALTER TABLE virement ADD CONSTRAINT FK_2D4DCFA66EF574BE FOREIGN KEY (account_2_id) REFERENCES `account` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE virement');
    }
}
