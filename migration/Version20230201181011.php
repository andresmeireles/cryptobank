<?php

declare(strict_types=1);

namespace CryptoBank\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201181011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CAC89EAC96901F54 (number), UNIQUE INDEX UNIQ_CAC89EACA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auths (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, account_id INT DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_941F8EBA76ED395 (user_id), UNIQUE INDEX UNIQ_941F8EB9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jwts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, INDEX IDX_A63E2ADAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cnpj_cpf VARCHAR(255) NOT NULL, rg_ie VARCHAR(255) NOT NULL, birth_date_foundation_date DATE NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E96A7EFAB2 (cnpj_cpf), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EACA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE auths ADD CONSTRAINT FK_941F8EBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE auths ADD CONSTRAINT FK_941F8EB9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
        $this->addSql('ALTER TABLE jwts ADD CONSTRAINT FK_A63E2ADAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts DROP FOREIGN KEY FK_CAC89EACA76ED395');
        $this->addSql('ALTER TABLE auths DROP FOREIGN KEY FK_941F8EBA76ED395');
        $this->addSql('ALTER TABLE auths DROP FOREIGN KEY FK_941F8EB9B6B5FBA');
        $this->addSql('ALTER TABLE jwts DROP FOREIGN KEY FK_A63E2ADAA76ED395');
        $this->addSql('DROP TABLE accounts');
        $this->addSql('DROP TABLE auths');
        $this->addSql('DROP TABLE jwts');
        $this->addSql('DROP TABLE users');
    }
}
