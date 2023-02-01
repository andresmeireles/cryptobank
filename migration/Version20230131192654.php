<?php

declare(strict_types=1);

namespace CryptoBank\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131192654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auths (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, account_id INT DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_941F8EBA76ED395 (user_id), UNIQUE INDEX UNIQ_941F8EB9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auths ADD CONSTRAINT FK_941F8EBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE auths ADD CONSTRAINT FK_941F8EB9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auths DROP FOREIGN KEY FK_941F8EBA76ED395');
        $this->addSql('ALTER TABLE auths DROP FOREIGN KEY FK_941F8EB9B6B5FBA');
        $this->addSql('DROP TABLE auths');
    }
}
