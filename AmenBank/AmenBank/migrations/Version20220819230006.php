<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819230006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account CHANGE solde solde DOUBLE PRECISION NOT NULL, CHANGE date_solde date_solde DATE DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A496901F54 ON account (number)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_7D3656A496901F54 ON account');
        $this->addSql('ALTER TABLE account CHANGE solde solde DOUBLE PRECISION DEFAULT \'0\' NOT NULL, CHANGE date_solde date_solde DATE DEFAULT \'CURRENT_TIMESTAMP\'');
    }
}
